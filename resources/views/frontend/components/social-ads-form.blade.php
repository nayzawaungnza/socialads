
<form id="contactForm" action="{{ route('website.contact-form-store') }}" method="POST">
    @csrf
    <div class="billing-details">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="form-group">
                    <label>FIRST NAME <span class="required">*</span></label>
                    <input type="text" name="first_name" class="form-control" required>
                    <span class="text-danger error-message" data-field="first_name"></span>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="form-group">
                    <label>LAST NAME <span class="required">*</span></label>
                    <input type="text" name="last_name" class="form-control" required>
                    <span class="text-danger error-message" data-field="last_name"></span>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="form-group">
                    <label>PHONE NUMBER <span class="required">*</span></label>
                    <input type="text" name="phone_number" class="form-control" required>
                    <span class="text-danger error-message" data-field="phone_number"></span>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="form-group">
                    <label>EMAIL <span class="required">*</span></label>
                    <input type="email" name="email" class="form-control" required>
                    <span class="text-danger error-message" data-field="email"></span>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="form-group">
                    <label>COMPANY NAME</label>
                    <input type="text" name="company_name" class="form-control">
                    <span class="text-danger error-message" data-field="company_name"></span>
                </div>
            </div>

            <div class="col-lg-12 col-md-6">
                <div class="form-group">
                    <label>WHAT SERVICES ARE YOU INTERESTED IN?</label>
                    @if($services)
                    <select class="form-select form-control" name="service_id" aria-label=".form-select-sm" required>
                        <option value="" disabled selected>WHAT SERVICES ARE YOU INTERESTED IN?</option>
                        @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                    @endif
                    <span class="text-danger error-message" data-field="service_id"></span>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="form-group">
                    <textarea name="message" id="notes" cols="30" rows="5" placeholder="TELL US MORE ABOUT YOUR PROJECT" class="form-control" required></textarea>
                    <span class="text-danger error-message" data-field="message"></span>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="subscribe" name="subscribe" value="1">
                        <label class="form-check-label" for="subscribe">Subscribe to our newsletter</label>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="form-group">
                    <button type="submit" class="quote-us-button default-btn"><span>Send Message</span><i class="bx bx-paper-plane"></i></button>
                </div>
                <div id="msgSubmit" class="h6 text-center mt-2 hidden"></div>
            </div>
        </div>
    </div>
</form>