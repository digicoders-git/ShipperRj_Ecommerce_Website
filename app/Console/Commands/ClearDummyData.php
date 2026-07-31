<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClearDummyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clear-dummy {--include-users : Also clear customer users table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear dummy/testing data (orders, carts, wallet transactions, support, contacts, etc.) keeping products, sliders, admins, and settings intact.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->warn('This command will TRUNCATE test data tables (Orders, Carts, Wallet Transactions, Support Tickets, Contacts, Reviews, etc.).');
        
        if (!$this->confirm('Do you want to proceed?')) {
            $this->info('Operation cancelled.');
            return 0;
        }

        $clearUsers = $this->option('include-users') || $this->confirm('Do you also want to clear customer user accounts (users table)? (Admins in "admins" table are 100% safe)');

        Schema::disableForeignKeyConstraints();

        $tablesToClear = [
            'orders',
            'order_items',
            'order_trackings',
            'carts',
            'wishlists',
            'wallet_transactions',
            'refunds',
            'complaints',
            'support_tickets',
            'contacts',
            'seller_inquiries',
            'user_addresses',
            'product_reviews',
        ];

        if ($clearUsers) {
            $tablesToClear[] = 'users';
        }

        foreach ($tablesToClear as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->info("✔ Cleared table: {$table}");
            }
        }

        Schema::enableForeignKeyConstraints();

        $this->info("\nSUCCESS: All dummy test data has been cleared successfully!");
        $this->info("Preserved: Admins, Sub-Admins, Sliders, Products, Categories, Settings, FAQs, Coupons.");

        return 0;
    }
}
