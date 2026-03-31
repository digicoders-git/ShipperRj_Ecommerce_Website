@extends('layouts.admin')

@section('title', 'Transactions')

@section('admin_content')
<div class="mb-4">
    <h5 class="fw-bold mb-0">Transaction History</h5>
    <p class="text-secondary small">Wallet and payment transactions log</p>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table admin-datatable table-borderless text-secondary align-middle">
            <thead>
                <tr class="border-bottom border-white border-opacity-10">
                    <th class="small fw-bold py-3">ID</th>
                    <th class="small fw-bold py-3">Customer</th>
                    <th class="small fw-bold py-3">Type</th>
                    <th class="small fw-bold py-3">Amount</th>
                    <th class="small fw-bold py-3">Description</th>
                    <th class="small fw-bold py-3">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr class="border-bottom border-white border-opacity-5">
                    <td class="small">#{{ $loop->iteration }}</td>
                    <td>
                        <div class="small text-white">{{ $transaction->user->name ?? 'Guest' }}</div>
                        <div class="x-small text-secondary">{{ $transaction->user->email ?? 'N/A' }}</div>
                    </td>
                    <td>
                        <span class="badge bg-{{ $transaction->display_type == 'credit' ? 'success' : 'danger' }} bg-opacity-10 text-{{ $transaction->display_type == 'credit' ? 'success' : 'danger' }} px-2 py-1 x-small">
                            {{ strtoupper($transaction->display_type) }}
                        </span>
                        @if(isset($transaction->source))
                            <div class="xx-small text-secondary mt-1 opacity-50">{{ strtoupper($transaction->source) }}</div>
                        @endif
                    </td>
                    <td class="fw-bold text-{{ $transaction->display_type == 'credit' ? 'success' : 'danger' }}">
                        {{ $transaction->display_type == 'credit' ? '+' : '-' }}₹{{ number_format($transaction->amount, 2) }}
                    </td>
                    <td class="small line-height-sm" style="max-width: 250px;">{{ $transaction->description }}</td>
                    <td class="small text-nowrap">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M, Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection









