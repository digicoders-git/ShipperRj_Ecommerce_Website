@extends('layouts.admin')

@section('title', 'Users')

@section('admin_content')
    <div class="mb-4">
        <h5 class="fw-bold mb-0">Customer Management</h5>
        <p class="text-secondary small">View and manage registered users</p>
    </div>

    <div class="glass-card">
        <div class="table-responsive">
            <table class="table admin-datatable table-borderless text-secondary align-middle">
                <thead>
                    <tr class="border-bottom border-white border-opacity-10">
                         <th class="serial-col">S.No</th>
                        <th class="small fw-bold py-3">ID</th>
                        <th class="small fw-bold py-3">Customer</th>
                        <th class="small fw-bold py-3">Mobile</th>
                        <th class="small fw-bold py-3">Password</th>
                        <th class="small fw-bold py-3">Address</th>
                        <th class="small fw-bold py-3">Wallet</th>
                        <th class="small fw-bold py-3">Status</th>
                        <th class="small fw-bold py-3">Joined Date</th>
                        <th class="small fw-bold py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-bottom border-white border-opacity-5">
                            <td class="serial-cell small">#{{ $loop->iteration }}</td>
                            
                            <td class="small">{{ $user->id}}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @php
                                        $profile_photo = $user->profile_photo ? asset('storage/' . $user->profile_photo) : null;
                                    @endphp
                                    @if($profile_photo)
                                        <img src="{{ $profile_photo }}" class="rounded-circle me-2"
                                            style="width: 35px; height: 35px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-primary bg-opacity-20 d-flex align-items-center justify-content-center text-white small fw-bold me-2"
                                            style="width: 35px; height: 35px;">{{ substr($user->name, 0, 1) }}</div>
                                    @endif
                                    <div>
                                        <div class="fw-bold small">{{ $user->name }}</div>
                                        <div class="x-small text-secondary">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="small text-white">{{ $user->mobile ?? 'N/A' }}</td>
                            <td class="small">
                                <span class="text-info font-monospace fw-bold">{{ $user->plain_password ?? 'N/A' }}</span>
                            </td>
                            <td class="small text-secondary fw-bold"
                                style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: wrap;">
                                @if($user->address)
                                    {{ $user->address }}, {{ $user->city }} ({{ $user->pincode }})
                                @else
                                    <span class="opacity-50">Not Set</span>
                                @endif
                            </td>
                            <td>
                                <span
                                    class="text-success fw-bold small">₹{{ number_format($user->wallet_balance ?? 0, 2) }}</span>
                            </td>
                            <td>
                                @if($user->is_blocked)
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill x-small px-3">Blocked</span>
                                @else
                                    <span
                                        class="badge bg-success bg-opacity-10 text-success rounded-pill x-small px-3">Active</span>
                                @endif
                            </td>
                            <td class="small">{{ $user->created_at ? $user->created_at->format('d M, Y') : 'N/A' }}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5"
                                        title="View Details">
                                        <i class="bi bi-eye text-primary"></i>
                                    </a>
                                    <form action="{{ route('admin.users.toggle-block', $user->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5 btn-block-toggle"
                                            data-status="{{ $user->is_blocked ? 'unblock' : 'block' }}"
                                            title="{{ $user->is_blocked ? 'Unblock User' : 'Block User' }}">
                                            @if($user->is_blocked)
                                                <i class="bi bi-unlock text-success"></i>
                                            @else
                                                <i class="bi bi-slash-circle text-danger"></i>
                                            @endif
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5 btn-delete"
                                            title="Delete User">
                                            <i class="bi bi-trash text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection