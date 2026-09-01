@extends('layouts.admin')

@section('title', 'Web Push Notifications')

@section('admin_content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-white fw-bold mb-1"><i class="bi bi-bell-fill text-warning me-2"></i>Web Push Notifications</h3>
            <p class="text-secondary small mb-0">Broadcast instant native push notifications directly to user browsers & devices.</p>
        </div>
        <button type="button" id="testPushBtn" class="btn btn-outline-warning rounded-pill px-4 btn-sm fw-bold shadow-sm" onclick="sendTestPush()">
            <i class="bi bi-send-fill me-2" id="testPushIcon"></i><span id="testPushText">Send Test Notification to Me</span>
        </button>
    </div>

    <!-- Analytics Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="glass-card p-4 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary x-small text-uppercase fw-bold ls-1 d-block mb-1">Total Subscribers</span>
                        <h2 class="text-white fw-black mb-0">{{ number_format($totalSubscribers) }}</h2>
                    </div>
                    <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded-4 p-3 fs-3">
                        <i class="bi bi-bell"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card p-4 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary x-small text-uppercase fw-bold ls-1 d-block mb-1">User Subscribers</span>
                        <h2 class="text-white fw-black mb-0">{{ number_format($userSubscribers) }}</h2>
                    </div>
                    <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-4 p-3 fs-3">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card p-4 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary x-small text-uppercase fw-bold ls-1 d-block mb-1">Guest Subscribers</span>
                        <h2 class="text-white fw-black mb-0">{{ number_format($guestSubscribers) }}</h2>
                    </div>
                    <div class="icon-shape bg-info bg-opacity-10 text-info rounded-4 p-3 fs-3">
                        <i class="bi bi-laptop"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card p-4 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary x-small text-uppercase fw-bold ls-1 d-block mb-1">VAPID Status</span>
                        <h5 class="text-success fw-bold mb-0"><i class="bi bi-check-circle-fill me-1"></i>Active</h5>
                    </div>
                    <div class="icon-shape bg-success bg-opacity-10 text-success rounded-4 p-3 fs-3">
                        <i class="bi bi-shield-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Broadcast Push Form -->
        <div class="col-lg-6">
            <div class="glass-card p-4 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10 h-100">
                <h5 class="text-white fw-bold mb-3"><i class="bi bi-broadcast me-2 text-primary"></i>Compose & Broadcast Push Notification</h5>
                <p class="x-small text-secondary mb-4">Craft a notification to instantly alert your customers about deals, order updates, or new launches.</p>

                <form id="broadcastForm" action="{{ route('admin.push.broadcast') }}" method="POST" onsubmit="handleBroadcastSubmit(event)">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">Target Audience</label>
                        <select name="target" class="form-select glass-input">
                            <option value="all">All Subscribers (Users & Guests) - [{{ $totalSubscribers }}]</option>
                            <option value="users">Logged-In Registered Users Only - [{{ $userSubscribers }}]</option>
                            <option value="guests">Guest Visitor Devices Only - [{{ $guestSubscribers }}]</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">Notification Title</label>
                        <input type="text" name="title" class="form-control glass-input" placeholder="e.g. Mega Weekend Sale is Live!" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">Notification Message / Body</label>
                        <textarea name="body" class="form-control glass-input" rows="3" placeholder="e.g. Get up to 50% discount on all premium electronics. Limited time offer!" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">Click Redirect URL</label>
                        <input type="url" name="url" class="form-control glass-input" value="{{ url('/products') }}" placeholder="https://">
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Notification Icon URL (Optional)</label>
                            <input type="url" name="icon" class="form-control glass-input" placeholder="{{ asset('images/logo-icon.png') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Banner Image URL (Optional)</label>
                            <input type="url" name="image" class="form-control glass-input" placeholder="https://example.com/banner.jpg">
                        </div>
                    </div>

                    <button type="submit" id="broadcastBtn" class="btn btn-warning w-100 py-3 rounded-pill fw-bold text-dark shadow-sm">
                        <i class="bi bi-broadcast me-2" id="broadcastBtnIcon"></i>
                        <span id="broadcastBtnText">Send Web Push Notification Broadcast</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Recent Subscriptions List -->
        <div class="col-lg-6">
            <div class="glass-card p-4 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10 h-100">
                <h5 class="text-white fw-bold mb-3"><i class="bi bi-device-ssd me-2 text-info"></i>Active Push Subscriptions</h5>
                <p class="x-small text-secondary mb-4">Recently registered device push endpoints in your database.</p>

                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <thead>
                            <tr class="xx-small text-secondary text-uppercase border-bottom border-white border-opacity-10">
                                <th>Subscriber</th>
                                <th>Browser / Device</th>
                                <th class="text-end">Subscribed At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSubscriptions as $sub)
                                <tr class="border-bottom border-white border-opacity-5">
                                    <td class="py-3">
                                        @if($sub->user)
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-primary rounded-circle p-2"><i class="bi bi-person-fill"></i></span>
                                                <div>
                                                    <span class="d-block small fw-bold text-white">{{ $sub->user->name }}</span>
                                                    <span class="x-small text-muted">{{ $sub->user->email }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-secondary rounded-circle p-2"><i class="bi bi-laptop"></i></span>
                                                <span class="small fw-medium text-secondary">Guest Visitor</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <span class="x-small text-secondary text-truncate d-inline-block" style="max-width: 180px;" title="{{ $sub->user_agent }}">
                                            {{ Str::limit($sub->user_agent ?? 'Unknown Browser', 30) }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-end x-small text-muted">
                                        {{ $sub->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-secondary small">No push subscriptions recorded yet. Visit the website to subscribe!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function handleBroadcastSubmit(e) {
        Swal.fire({
            title: 'Broadcasting Push Notification...',
            text: 'Delivering notification payload to target subscribers. Please wait.',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
    }

    async function sendTestPush() {
        let currentEndpoint = null;
        try {
            if ('serviceWorker' in navigator && window.WebPushManager && window.WebPushManager.swRegistration) {
                const sub = await window.WebPushManager.swRegistration.pushManager.getSubscription();
                if (sub) {
                    currentEndpoint = sub.endpoint;
                }
            }
        } catch (e) {
            console.log('Error getting current browser subscription:', e);
        }

        Swal.fire({
            title: 'Sending Test Push...',
            text: 'Triggering test web push notification to your device.',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        fetch("{{ route('push.test') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ endpoint: currentEndpoint })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Push Sent!', data.message, 'success');
            } else {
                Swal.fire('Notice', data.message || 'No subscription active.', 'info');
            }
        })
        .catch(err => {
            Swal.fire('Error', 'Failed to send test push notification.', 'error');
        });
    }
</script>
@endpush
