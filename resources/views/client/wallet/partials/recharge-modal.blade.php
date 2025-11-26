<!-- Recharge Wallet Modal -->
<div class="modal fade" id="rechargeWalletModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-bottom bg-primary text-white">
        <div class="d-flex align-items-center">
          <div class="avatar avatar-md me-3" style="background-color: rgba(255,255,255,0.2);">
            <i class="ri-wallet-3-line text-white" style="font-size: 1.5rem;"></i>
          </div>
          <div>
            <h5 class="modal-title mb-0">Recharge Wallet</h5>
            <small class="opacity-75">Add money to your wallet for seamless payments</small>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('client.wallet.recharge') }}" method="POST" id="rechargeForm">
        @csrf
        <div class="modal-body p-4">
          <!-- Current Balance -->
          <div class="alert alert-light border d-flex align-items-center mb-4" role="alert">
            <div class="avatar avatar-sm me-3" style="background-color: #10b98120;">
              <i class="ri-wallet-3-line text-success" style="font-size: 1.2rem;"></i>
            </div>
            <div>
              <strong>Current Balance:</strong>
              <span class="text-primary fs-5 fw-bold ms-2">₹{{ number_format($wallet->balance ?? 0, 2) }}</span>
            </div>
          </div>

          <!-- Amount Selection -->
          <div class="mb-4">
            <label class="form-label fw-semibold mb-3">
              <i class="ri-money-rupee-circle-line me-2"></i>Select Amount
            </label>
            
            <!-- Quick Amount Buttons -->
            <div class="row g-2 mb-3">
              <div class="col-4 col-md-3">
                <button type="button" class="btn btn-outline-primary w-100 quick-amount-btn" data-amount="500">
                  ₹500
                </button>
              </div>
              <div class="col-4 col-md-3">
                <button type="button" class="btn btn-outline-primary w-100 quick-amount-btn" data-amount="1000">
                  ₹1,000
                </button>
              </div>
              <div class="col-4 col-md-3">
                <button type="button" class="btn btn-outline-primary w-100 quick-amount-btn" data-amount="2000">
                  ₹2,000
                </button>
              </div>
              <div class="col-4 col-md-3">
                <button type="button" class="btn btn-outline-primary w-100 quick-amount-btn" data-amount="5000">
                  ₹5,000
                </button>
              </div>
            </div>

            <!-- Custom Amount Input -->
            <div class="input-group input-group-lg">
              <span class="input-group-text bg-light">
                <i class="ri-money-rupee-circle-line"></i>
              </span>
              <input 
                type="number" 
                class="form-control" 
                name="amount" 
                id="rechargeAmount" 
                min="100" 
                step="100" 
                value="500" 
                placeholder="Enter custom amount"
                required
              >
              <span class="input-group-text bg-light">INR</span>
            </div>
            <small class="text-muted mt-2 d-block">
              <i class="ri-information-line me-1"></i>
              Minimum recharge amount: ₹100
            </small>
          </div>

          <!-- Payment Method Selection -->
          <div class="mb-4">
            <label class="form-label fw-semibold mb-3">
              <i class="ri-bank-card-line me-2"></i>Select Payment Method
            </label>
            <div class="row g-3">
              <!-- Card -->
              <div class="col-6 col-md-4">
                <label class="form-check-label w-100 position-relative">
                  <input type="radio" class="form-check-input position-absolute" name="payment_method" value="card" checked style="opacity: 0; z-index: -1;">
                  <div class="card border payment-method-card h-100 text-center p-3 cursor-pointer transition-all" style="cursor: pointer; transition: all 0.3s ease;">
                    <div class="avatar avatar-lg mx-auto mb-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                      <i class="ri-bank-card-line text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="mb-0 fw-semibold">Card</h6>
                    <small class="text-muted">Credit/Debit</small>
                  </div>
                </label>
              </div>

              <!-- Netbanking -->
              <div class="col-6 col-md-4">
                <label class="form-check-label w-100 position-relative">
                  <input type="radio" class="form-check-input position-absolute" name="payment_method" value="netbanking" style="opacity: 0; z-index: -1;">
                  <div class="card border payment-method-card h-100 text-center p-3 cursor-pointer transition-all" style="cursor: pointer; transition: all 0.3s ease;">
                    <div class="avatar avatar-lg mx-auto mb-2" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                      <i class="ri-bank-line text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="mb-0 fw-semibold">Netbanking</h6>
                    <small class="text-muted">Bank Transfer</small>
                  </div>
                </label>
              </div>

              <!-- UPI -->
              <div class="col-6 col-md-4">
                <label class="form-check-label w-100 position-relative">
                  <input type="radio" class="form-check-input position-absolute" name="payment_method" value="upi" style="opacity: 0; z-index: -1;">
                  <div class="card border payment-method-card h-100 text-center p-3 cursor-pointer transition-all" style="cursor: pointer; transition: all 0.3s ease;">
                    <div class="avatar avatar-lg mx-auto mb-2" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                      <i class="ri-qr-code-line text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="mb-0 fw-semibold">UPI</h6>
                    <small class="text-muted">Instant Payment</small>
                  </div>
                </label>
              </div>

              <!-- Google Pay -->
              <div class="col-6 col-md-4">
                <label class="form-check-label w-100 position-relative">
                  <input type="radio" class="form-check-input position-absolute" name="payment_method" value="google_pay" style="opacity: 0; z-index: -1;">
                  <div class="card border payment-method-card h-100 text-center p-3 cursor-pointer transition-all" style="cursor: pointer; transition: all 0.3s ease;">
                    <div class="avatar avatar-lg mx-auto mb-2" style="background: linear-gradient(135deg, #4285F4 0%, #34A853 100%);">
                      <i class="ri-google-pay-line text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="mb-0 fw-semibold">Google Pay</h6>
                    <small class="text-muted">Fast & Secure</small>
                  </div>
                </label>
              </div>

              <!-- Paytm -->
              <div class="col-6 col-md-4">
                <label class="form-check-label w-100 position-relative">
                  <input type="radio" class="form-check-input position-absolute" name="payment_method" value="paytm" style="opacity: 0; z-index: -1;">
                  <div class="card border payment-method-card h-100 text-center p-3 cursor-pointer transition-all" style="cursor: pointer; transition: all 0.3s ease;">
                    <div class="avatar avatar-lg mx-auto mb-2" style="background: linear-gradient(135deg, #00BAF2 0%, #00C9FF 100%);">
                      <i class="ri-wallet-line text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="mb-0 fw-semibold">Paytm</h6>
                    <small class="text-muted">Digital Wallet</small>
                  </div>
                </label>
              </div>

              <!-- Wallets -->
              <div class="col-6 col-md-4">
                <label class="form-check-label w-100 position-relative">
                  <input type="radio" class="form-check-input position-absolute" name="payment_method" value="wallet" style="opacity: 0; z-index: -1;">
                  <div class="card border payment-method-card h-100 text-center p-3 cursor-pointer transition-all" style="cursor: pointer; transition: all 0.3s ease;">
                    <div class="avatar avatar-lg mx-auto mb-2" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                      <i class="ri-wallet-3-line text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="mb-0 fw-semibold">Wallets</h6>
                    <small class="text-muted">Other Wallets</small>
                  </div>
                </label>
              </div>
            </div>
          </div>

          <!-- Security Info -->
          <div class="alert alert-info border-0 d-flex align-items-start mb-0" role="alert">
            <i class="ri-shield-check-line me-2 mt-1" style="font-size: 1.2rem;"></i>
            <div>
              <strong>Secure Payment</strong>
              <p class="mb-0 small">Your payment is secured with industry-standard encryption. All transactions are safe and protected.</p>
            </div>
          </div>
        </div>
        <div class="modal-footer border-top bg-light">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="ri-close-line me-2"></i>Cancel
          </button>
          <button type="submit" class="btn btn-primary btn-lg">
            <i class="ri-arrow-right-line me-2"></i>Proceed to Payment
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.payment-method-card {
  transition: all 0.3s ease;
  cursor: pointer;
}

.payment-method-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}

.payment-method-card.border-primary {
  border-width: 2px !important;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2) !important;
}

.cursor-pointer {
  cursor: pointer;
}

.transition-all {
  transition: all 0.3s ease;
}
</style>
