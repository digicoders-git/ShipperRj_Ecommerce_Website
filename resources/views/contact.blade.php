@extends('layouts.app')

@section('content')
<div class="container py-5 page-fade-in">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="glass-card p-5 overflow-hidden position-relative">
                <div id="formSection">
                    <h1 class="display-5 fw-bold mb-4">Contact <span class="text-primary">Us</span></h1>
                    <p class="text-secondary mb-5">Have a question? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                    
                    <form id="contactForm">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control glass-input" placeholder="Enter your name" required>
                        </div>
                        <div class="row gx-3">
                            <div class="col-md-6 mb-4">
                                <label class="form-label text-secondary small text-uppercase fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control glass-input" placeholder="Enter your email" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label text-secondary small text-uppercase fw-bold">Mobile Number</label>
                                <input type="tel" name="phone" class="form-control glass-input" placeholder="e.g. 9876543210" 
                                       pattern="[6-9][0-9]{9}" maxlength="10" minlength="10" required
                                       title="Mobile number must start with 6, 7, 8, or 9 and must be exactly 10 digits.">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Subject</label>
                            <input type="text" name="subject" class="form-control glass-input" placeholder="Enter subject">
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Message</label>
                            <textarea name="message" class="form-control glass-input" rows="5" placeholder="How can we help?" required></textarea>
                        </div>
                        <div id="validationErrors" class="alert alert-danger d-none mb-4 py-2 small"></div>
                        <button type="submit" id="submitBtn" class="btn btn-premium w-100 py-3 mt-2">
                            <span id="btnText">Send Message</span>
                            <span id="btnLoader" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </form>

                    <div class="row mt-5 pt-4 border-top border-secondary border-opacity-25">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-uppercase small fw-bold text-primary">Email Support</h6>
                            <p class="text-secondary">support@premiumstore.com</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-uppercase small fw-bold text-primary">Office Address</h6>
                            <p class="text-secondary">123 Tech Avenue, Digital City, India</p>
                        </div>
                    </div>
                </div>

                <!-- Success Message Overly (Initially Hidden) -->
                <div id="successMessage" class="d-none position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-white glass-card border-0" style="z-index: 10;">
                    <div class="text-center p-5">
                        <div class="mb-4">
                            <i class="bi bi-check-circle-fill display-1 text-primary shadow-sm"></i>
                        </div>
                        <h2 class="fw-bold mb-3">Message Sent!</h2>
                        <p class="text-secondary lead mb-4">Your inquiry has been received. Our team will get back to you shortly.</p>
                        <button onclick="resetContactPage()" class="btn btn-premium px-5 rounded-pill">Send Another</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#contactForm').on('submit', function(e) {
            e.preventDefault();
            
            let formData = $(this).serialize();
            $('#btnText').addClass('d-none');
            $('#btnLoader').removeClass('d-none');
            $('#submitBtn').attr('disabled', true);

            $.ajax({
                url: "{{ route('contact.submit') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    $('#validationErrors').addClass('d-none');
                    $('#successMessage').removeClass('d-none').hide().fadeIn(500);
                    $('#contactForm')[0].reset();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorHtml = '<ul class="mb-0">';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value[0] + '</li>';
                        });
                        errorHtml += '</ul>';
                        $('#validationErrors').html(errorHtml).removeClass('d-none');
                    } else {
                        alert('Something went wrong. Please try again.');
                    }
                },
                complete: function() {
                    $('#btnText').removeClass('d-none');
                    $('#btnLoader').addClass('d-none');
                    $('#submitBtn').attr('disabled', false);
                }
            });
        });
    });

    function resetContactPage() {
        $('#successMessage').fadeOut(300, function() {
            $(this).addClass('d-none');
        });
    }
</script>
@endsection
