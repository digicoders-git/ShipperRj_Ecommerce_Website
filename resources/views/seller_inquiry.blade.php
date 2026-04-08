@extends('layouts.app')

@section('content')
    <div class="container py-5 page-fade-in">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="glass-card p-5 overflow-hidden position-relative">
                    <div id="formSection">
                        <div class="text-center mb-5">
                            <h1 class="display-5 fw-bold mb-3">Grow Your Business <span class="text-primary">With Us
                                    🚀</span></h1>
                            <p class="text-secondary lead">Invest in your business and grow with our platform. Join
                                thousands of successful sellers today.</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('seller.inquiry.submit') }}" method="POST">
                            @csrf
                            <div class="row gx-3">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-secondary small text-uppercase fw-bold">Full Name</label>
                                    <input type="text" name="name"
                                        class="form-control glass-input @error('name') is-invalid @enderror"
                                        placeholder="Enter your name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-secondary small text-uppercase fw-bold">Email
                                        Address</label>
                                    <input type="email" name="email"
                                        class="form-control glass-input @error('email') is-invalid @enderror"
                                        placeholder="Enter your email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row gx-3">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-secondary small text-uppercase fw-bold">Mobile
                                        Number</label>
                                    <input type="tel" name="phone"
                                        class="form-control glass-input @error('phone') is-invalid @enderror"
                                        placeholder="e.g. 9876543210" pattern="[6-9][0-9]{9}" maxlength="10" minlength="10"
                                        value="{{ old('phone') }}" required
                                        title="Mobile number must start with 6, 7, 8, or 9 and must be exactly 10 digits.">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-secondary small text-uppercase fw-bold">Business
                                        Name</label>
                                    <input type="text" name="business_name"
                                        class="form-control glass-input @error('business_name') is-invalid @enderror"
                                        placeholder="Enter your business name" value="{{ old('business_name') }}">
                                    @error('business_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-secondary small text-uppercase fw-bold">Business Type</label>
                                <select name="business_type"
                                    class="form-select glass-input @error('business_type') is-invalid @enderror">
                                    <option value="" selected disabled>Select Business Type</option>
                                    <option value="Interested To Start New Business">Interested To Start New Business</option>
                                    <option value="Retailer">Retailer</option>
                                    <option value="Wholesaler">Wholesaler</option>
                                    <option value="Manufacturer">Manufacturer</option>
                                    <option value="Individual">Individual</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('business_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-secondary small text-uppercase fw-bold">Additional
                                    Message/Requirements</label>
                                <textarea name="message"
                                    class="form-control glass-input @error('message') is-invalid @enderror" rows="5"
                                    placeholder="Tell us more about your business...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-premium w-100 py-3 mt-2">
                                SUBMIT APPLICATION
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection