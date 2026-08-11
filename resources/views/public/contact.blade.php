@extends('layouts.public')

@section('content')
<div class="bg-light py-5 border-bottom mb-5">
    <div class="container text-center">
        <h1 class="fw-bold mb-3" data-i18n="contact_title">Contact Us</h1>
        <p class="text-muted lead mb-0" data-i18n="contact_subtitle">We are here to help and answer any question you might have.</p>
    </div>
</div>

<div class="container mb-5 pb-5">
    <div class="row g-5">
        
        <div class="col-md-5">
            <h3 class="fw-bold mb-4" data-i18n="contact_get_in_touch">Get In Touch</h3>
            <p class="text-muted mb-4" data-i18n="contact_desc">Whether you have a question about our fleet, pricing, need a custom rental package, or anything else, our team is ready to answer all your questions.</p>
            
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-geo-alt-fill fs-5"></i>
                </div>
                <div class="ms-3">
                    <h6 class="fw-bold mb-1" data-i18n="contact_location">Our Location</h6>
                    <p class="text-muted mb-0">123 Car Street, Dhaka, Bangladesh</p>
                </div>
            </div>

            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-envelope-fill fs-5"></i>
                </div>
                <div class="ms-3">
                    <h6 class="fw-bold mb-1" data-i18n="contact_email_us">Email Us</h6>
                    <p class="text-muted mb-0">support@rentacar.example.com</p>
                </div>
            </div>

            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-telephone-fill fs-5"></i>
                </div>
                <div class="ms-3">
                    <h6 class="fw-bold mb-1" data-i18n="contact_call_us">Call Us</h6>
                    <p class="text-muted mb-0">+880 1711 123456</p>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow border-0 rounded-4 p-4 p-md-5">
                <h4 class="fw-bold mb-4" data-i18n="contact_send_msg">Send a Message</h4>
                <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Thanks for your message! This is a demo form, but in production this would send an email to our support team.'); this.reset();">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small" data-i18n="contact_your_name">Your Name</label>
                            <input type="text" class="form-control" required placeholder="John Doe">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small" data-i18n="contact_your_email">Your Email</label>
                            <input type="email" class="form-control" required placeholder="john@example.com">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small" data-i18n="contact_subject">Subject</label>
                            <input type="text" class="form-control" required placeholder="How can we help you?">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small" data-i18n="contact_msg_label">Message</label>
                            <textarea class="form-control" rows="5" required placeholder="Type your message here..."></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2" data-i18n="contact_send_btn">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
