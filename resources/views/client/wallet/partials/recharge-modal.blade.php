<!-- Recharge Wallet Modal -->
<div class="modal fade" id="rechargeWalletModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
      <!-- Header with gradient -->
      <div class="modal-header border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1.75rem 2rem;">
        <div class="d-flex align-items-center">
          <div style="width: 56px; height: 56px; background: rgba(255,255,255,0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; backdrop-filter: blur(10px);">
            <i class="ri-wallet-3-line text-white" style="font-size: 1.75rem;"></i>
          </div>
          <div>
            <h5 class="modal-title mb-1 text-white fw-semibold" style="font-size: 1.25rem;">Add Money to Wallet</h5>
            <p class="mb-0 text-white" style="opacity: 0.85; font-size: 0.875rem;">Quick & secure payments</p>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.8;"></button>
      </div>

      <form action="{{ route('client.wallet.recharge') }}" method="POST" id="rechargeForm">
        @csrf
        <div class="modal-body p-4" style="background: #fafafa;">
          
          <!-- Current Balance Card -->
          <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #86efac; border-radius: 16px; padding: 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem;">
            <div style="width: 48px; height: 48px; background: rgba(16, 185, 129, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
              <i class="ri-wallet-3-line" style="font-size: 1.5rem; color: #10b981;"></i>
            </div>
            <div>
              <p class="mb-0" style="font-size: 0.8125rem; color: #166534; font-weight: 500;">Current Balance</p>
              <h4 class="mb-0" style="color: #15803d; font-weight: 700; font-size: 1.5rem;">₹{{ number_format($wallet->balance ?? 0, 2) }}</h4>
            </div>
          </div>

          <!-- Amount Selection Section -->
          <div style="background: white; border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.04);">
            <label style="font-weight: 600; color: #1f2937; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; font-size: 0.9375rem;">
              <i class="ri-money-rupee-circle-line" style="color: #7c3aed;"></i>
              Select Amount
            </label>
            
            <!-- Quick Amount Buttons -->
            <div class="row g-2 mb-3">
              <div class="col-3">
                <button type="button" class="btn w-100 quick-amount-btn" data-amount="500" style="border-radius: 12px; padding: 0.75rem; font-weight: 600; border: 2px solid #e5e7eb; background: white; color: #374151; transition: all 0.2s ease;">
                  ₹500
                </button>
              </div>
              <div class="col-3">
                <button type="button" class="btn w-100 quick-amount-btn" data-amount="1000" style="border-radius: 12px; padding: 0.75rem; font-weight: 600; border: 2px solid #e5e7eb; background: white; color: #374151; transition: all 0.2s ease;">
                  ₹1,000
                </button>
              </div>
              <div class="col-3">
                <button type="button" class="btn w-100 quick-amount-btn" data-amount="2000" style="border-radius: 12px; padding: 0.75rem; font-weight: 600; border: 2px solid #e5e7eb; background: white; color: #374151; transition: all 0.2s ease;">
                  ₹2,000
                </button>
              </div>
              <div class="col-3">
                <button type="button" class="btn w-100 quick-amount-btn" data-amount="5000" style="border-radius: 12px; padding: 0.75rem; font-weight: 600; border: 2px solid #e5e7eb; background: white; color: #374151; transition: all 0.2s ease;">
                  ₹5,000
                </button>
              </div>
            </div>

            <!-- Custom Amount Input -->
            <div class="input-group" style="border-radius: 12px; overflow: hidden; border: 2px solid #e5e7eb; background: white;">
              <span class="input-group-text" style="background: #f9fafb; border: none; padding: 0.875rem 1rem;">
                <i class="ri-money-rupee-circle-line" style="font-size: 1.25rem; color: #6b7280;"></i>
              </span>
              <input 
                type="number" 
                class="form-control" 
                name="amount" 
                id="rechargeAmount" 
                min="100" 
                step="100" 
                value="500" 
                placeholder="Enter amount"
                required
                style="border: none; font-size: 1.125rem; font-weight: 600; padding: 0.875rem 1rem;"
              >
              <span class="input-group-text" style="background: #f9fafb; border: none; font-weight: 500; color: #6b7280; padding: 0.875rem 1rem;">INR</span>
            </div>
            <small style="display: block; margin-top: 0.75rem; color: #9ca3af; font-size: 0.8125rem;">
              <i class="ri-information-line me-1"></i>
              Minimum amount: ₹100
            </small>
          </div>

          <!-- Payment Methods Section -->
          <div style="background: white; border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.04);">
            <label style="font-weight: 600; color: #1f2937; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.25rem; font-size: 0.9375rem;">
              <i class="ri-bank-card-line" style="color: #7c3aed;"></i>
              Payment Method
            </label>
            <div class="row g-3">
              <!-- Card -->
              <div class="col-4">
                <label class="d-block position-relative" style="cursor: pointer;">
                  <input type="radio" class="position-absolute" name="payment_method" value="card" checked style="opacity: 0; position: absolute; z-index: -1;">
                  <div class="payment-method-card text-center" style="border: 2px solid #e5e7eb; border-radius: 14px; padding: 1.25rem 0.75rem; transition: all 0.3s ease; background: white;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; margin: 0 auto 0.75rem; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                      <i class="ri-bank-card-line text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h6 style="font-weight: 600; color: #1f2937; margin-bottom: 0.25rem; font-size: 0.875rem;">Card</h6>
                    <small style="color: #9ca3af; font-size: 0.75rem;">Credit/Debit</small>
                  </div>
                </label>
              </div>

              <!-- UPI -->
              <div class="col-4">
                <label class="d-block position-relative" style="cursor: pointer;">
                  <input type="radio" class="position-absolute" name="payment_method" value="upi" style="opacity: 0; position: absolute; z-index: -1;">
                  <div class="payment-method-card text-center" style="border: 2px solid #e5e7eb; border-radius: 14px; padding: 1.25rem 0.75rem; transition: all 0.3s ease; background: white;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; margin: 0 auto 0.75rem; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                      <i class="ri-qr-code-line text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h6 style="font-weight: 600; color: #1f2937; margin-bottom: 0.25rem; font-size: 0.875rem;">UPI</h6>
                    <small style="color: #9ca3af; font-size: 0.75rem;">Instant Pay</small>
                  </div>
                </label>
              </div>

              <!-- Netbanking -->
              <div class="col-4">
                <label class="d-block position-relative" style="cursor: pointer;">
                  <input type="radio" class="position-absolute" name="payment_method" value="netbanking" style="opacity: 0; position: absolute; z-index: -1;">
                  <div class="payment-method-card text-center" style="border: 2px solid #e5e7eb; border-radius: 14px; padding: 1.25rem 0.75rem; transition: all 0.3s ease; background: white;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; margin: 0 auto 0.75rem; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                      <i class="ri-bank-line text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h6 style="font-weight: 600; color: #1f2937; margin-bottom: 0.25rem; font-size: 0.875rem;">Netbanking</h6>
                    <small style="color: #9ca3af; font-size: 0.75rem;">Bank Transfer</small>
                  </div>
                </label>
              </div>

              <!-- Google Pay -->
              <div class="col-4">
                <label class="d-block position-relative" style="cursor: pointer;">
                  <input type="radio" class="position-absolute" name="payment_method" value="google_pay" style="opacity: 0; position: absolute; z-index: -1;">
                  <div class="payment-method-card text-center" style="border: 2px solid #e5e7eb; border-radius: 14px; padding: 1.25rem 0.75rem; transition: all 0.3s ease; background: white;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; margin: 0 auto 0.75rem; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #4285F4 0%, #34A853 100%);">
                      <i class="ri-google-fill text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h6 style="font-weight: 600; color: #1f2937; margin-bottom: 0.25rem; font-size: 0.875rem;">GPay</h6>
                    <small style="color: #9ca3af; font-size: 0.75rem;">Google Pay</small>
                  </div>
                </label>
              </div>

              <!-- Paytm -->
              <div class="col-4">
                <label class="d-block position-relative" style="cursor: pointer;">
                  <input type="radio" class="position-absolute" name="payment_method" value="paytm" style="opacity: 0; position: absolute; z-index: -1;">
                  <div class="payment-method-card text-center" style="border: 2px solid #e5e7eb; border-radius: 14px; padding: 1.25rem 0.75rem; transition: all 0.3s ease; background: white;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; margin: 0 auto 0.75rem; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #00BAF2 0%, #00C9FF 100%);">
                      <i class="ri-wallet-line text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h6 style="font-weight: 600; color: #1f2937; margin-bottom: 0.25rem; font-size: 0.875rem;">Paytm</h6>
                    <small style="color: #9ca3af; font-size: 0.75rem;">Wallet</small>
                  </div>
                </label>
              </div>

              <!-- Other Wallets -->
              <div class="col-4">
                <label class="d-block position-relative" style="cursor: pointer;">
                  <input type="radio" class="position-absolute" name="payment_method" value="wallet" style="opacity: 0; position: absolute; z-index: -1;">
                  <div class="payment-method-card text-center" style="border: 2px solid #e5e7eb; border-radius: 14px; padding: 1.25rem 0.75rem; transition: all 0.3s ease; background: white;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; margin: 0 auto 0.75rem; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                      <i class="ri-wallet-3-line text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h6 style="font-weight: 600; color: #1f2937; margin-bottom: 0.25rem; font-size: 0.875rem;">Others</h6>
                    <small style="color: #9ca3af; font-size: 0.75rem;">More Options</small>
                  </div>
                </label>
              </div>
            </div>
          </div>

          <!-- Security Badge -->
          <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #93c5fd; border-radius: 14px; padding: 1rem 1.25rem; display: flex; align-items: flex-start; gap: 0.875rem;">
            <div style="width: 40px; height: 40px; background: rgba(59, 130, 246, 0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
              <i class="ri-shield-check-line" style="font-size: 1.25rem; color: #2563eb;"></i>
            </div>
            <div>
              <h6 style="font-weight: 600; color: #1e40af; margin-bottom: 0.25rem; font-size: 0.875rem;">100% Secure Payment</h6>
              <p style="margin: 0; font-size: 0.8125rem; color: #3b82f6; line-height: 1.5;">All transactions are encrypted and protected with industry-standard security.</p>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer border-0" style="background: white; padding: 1.25rem 2rem 1.75rem;">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 12px; padding: 0.75rem 1.5rem; font-weight: 500;">
            Cancel
          </button>
          <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 12px; padding: 0.75rem 2rem; font-weight: 600; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.35);">
            <i class="ri-lock-line me-2"></i>Pay Securely
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.payment-method-card {
  cursor: pointer;
}

.payment-method-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
  border-color: #c7d2fe !important;
}

input[name="payment_method"]:checked + .payment-method-card {
  border-color: #7c3aed !important;
  background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%) !important;
  box-shadow: 0 4px 15px rgba(124, 58, 237, 0.15) !important;
}

.quick-amount-btn:hover {
  border-color: #7c3aed !important;
  color: #7c3aed !important;
  background: #faf5ff !important;
}

.quick-amount-btn.active,
.quick-amount-btn.btn-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
  border-color: transparent !important;
  color: white !important;
}

#rechargeAmount:focus {
  outline: none;
  box-shadow: none;
}

.input-group:focus-within {
  border-color: #7c3aed !important;
  box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}
</style>
