<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        try {
            $settings = Setting::all()->pluck('value', 'key')->toArray();
        } catch (\Exception $e) {
            \Log::error('Settings Fetch Error: ' . $e->getMessage());
            $settings = [];
        }
        return view('admin.settings', compact('settings'));
    }

    public function store(Request $request)
    {
        \Log::info('Saving Settings:', $request->except('_token'));
        try {
            $data = $request->except('_token');

            // Clean and encode Online Shipping Tiers
            if (isset($data['shipping_tiers_online'])) {
                $rawOnline = is_array($data['shipping_tiers_online']) ? $data['shipping_tiers_online'] : [];
                $onlineTiers = [];
                foreach ($rawOnline as $tier) {
                    if (isset($tier['min_price']) && isset($tier['shipping_percent'])) {
                        $minP = (float) ($tier['min_price'] ?? 0);
                        $maxP = ($tier['max_price'] !== null && $tier['max_price'] !== '') ? (float) $tier['max_price'] : null;
                        $pct = (float) ($tier['shipping_percent'] ?? 0);
                        $onlineTiers[] = [
                            'min_price' => $minP,
                            'max_price' => $maxP,
                            'shipping_percent' => $pct
                        ];
                    }
                }
                // Sort by min_price ascending
                usort($onlineTiers, function ($a, $b) {
                    return $a['min_price'] <=> $b['min_price'];
                });
                $data['shipping_tiers_online'] = json_encode(array_values($onlineTiers));
            } else {
                $data['shipping_tiers_online'] = json_encode([]);
            }

            // Clean and encode COD Shipping Tiers
            if (isset($data['shipping_tiers_cod'])) {
                $rawCod = is_array($data['shipping_tiers_cod']) ? $data['shipping_tiers_cod'] : [];
                $codTiers = [];
                foreach ($rawCod as $tier) {
                    if (isset($tier['min_price']) && isset($tier['shipping_percent'])) {
                        $minP = (float) ($tier['min_price'] ?? 0);
                        $maxP = ($tier['max_price'] !== null && $tier['max_price'] !== '') ? (float) $tier['max_price'] : null;
                        $pct = (float) ($tier['shipping_percent'] ?? 0);
                        $codTiers[] = [
                            'min_price' => $minP,
                            'max_price' => $maxP,
                            'shipping_percent' => $pct
                        ];
                    }
                }
                // Sort by min_price ascending
                usort($codTiers, function ($a, $b) {
                    return $a['min_price'] <=> $b['min_price'];
                });
                $data['shipping_tiers_cod'] = json_encode(array_values($codTiers));
            } else {
                $data['shipping_tiers_cod'] = json_encode([]);
            }

            foreach ($data as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => is_array($value) ? json_encode($value) : $value]
                );
            }

            // Clear settings cache & request cache
            Setting::clearRequestCache();

            return redirect()->back()->with('success', 'Settings updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Settings Save Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Critical Error: ' . $e->getMessage());
        }
    }

    public function deleteTier(Request $request)
    {
        try {
            $type = $request->input('type'); // 'online' or 'cod'
            $minPrice = (float) $request->input('min_price', 0);
            $maxPrice = ($request->input('max_price') !== null && $request->input('max_price') !== '') ? (float) $request->input('max_price') : null;

            $key = ($type === 'cod') ? 'shipping_tiers_cod' : 'shipping_tiers_online';
            $setting = Setting::where('key', $key)->first();

            if ($setting && !empty($setting->value)) {
                $tiers = json_decode($setting->value, true) ?? [];
                $newTiers = [];
                $deleted = false;

                foreach ($tiers as $t) {
                    $tMin = (float) ($t['min_price'] ?? 0);
                    $tMax = ($t['max_price'] !== null && $t['max_price'] !== '') ? (float) $t['max_price'] : null;

                    if (!$deleted && $tMin == $minPrice && $tMax == $maxPrice) {
                        $deleted = true;
                        continue; // Skip matching tier to remove from DB
                    }
                    $newTiers[] = $t;
                }

                $setting->update(['value' => json_encode(array_values($newTiers))]);
                Setting::clearRequestCache();

                return response()->json([
                    'success' => true,
                    'message' => 'Shipping tier deleted successfully!'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Shipping tier removed.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting tier: ' . $e->getMessage()
            ], 500);
        }
    }
}

