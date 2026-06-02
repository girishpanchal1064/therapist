<div class="modal fade" id="rechargeWalletModal" tabindex="-1" aria-labelledby="rechargeWalletModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered recharge-modal-dialog">
    <div class="modal-content recharge-modal">
      {{-- Compact header --}}
      <div class="recharge-modal-header">
        <div class="recharge-modal-header-main">
          <span class="recharge-modal-header-icon" aria-hidden="true">
            <i class="ri-wallet-3-line"></i>
          </span>
          <div>
            <h5 class="recharge-modal-title" id="rechargeWalletModalLabel">Add Money to Wallet</h5>
            <p class="recharge-modal-subtitle mb-0">Quick &amp; secure payments</p>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('client.wallet.recharge') }}" method="POST" id="rechargeForm" class="recharge-modal-form">
        @csrf

        <div class="recharge-modal-body">
          <div class="recharge-balance-row">
            <span class="recharge-balance-label">Current balance</span>
            <span class="recharge-balance-value">₹{{ number_format($wallet->balance ?? 0, 2) }}</span>
          </div>

          <div class="recharge-block">
            <h6 class="recharge-block-title">
              <i class="ri-money-rupee-circle-line"></i> Select amount
            </h6>
            <div class="recharge-amount-grid">
              @foreach([500, 1000, 2000, 5000] as $preset)
              <button type="button"
                class="quick-amount-btn {{ $preset === 500 ? 'is-active' : '' }}"
                data-amount="{{ $preset }}">
                ₹{{ number_format($preset) }}
              </button>
              @endforeach
            </div>
            <div class="recharge-amount-input">
              <i class="ri-money-rupee-circle-line recharge-amount-input-icon" aria-hidden="true"></i>
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
                aria-label="Recharge amount"
              >
              <span class="recharge-amount-suffix">INR</span>
            </div>
            <p class="recharge-hint mb-0">
              <i class="ri-information-line"></i> Minimum ₹100
            </p>
          </div>

          <div class="recharge-block">
            <h6 class="recharge-block-title">
              <i class="ri-bank-card-line"></i> Payment method
            </h6>
            <div class="recharge-pay-grid">
              @php
                $methods = [
                  ['value' => 'card', 'icon' => 'ri-bank-card-line', 'label' => 'Card'],
                  ['value' => 'upi', 'icon' => 'ri-qr-code-line', 'label' => 'UPI'],
                  ['value' => 'netbanking', 'icon' => 'ri-bank-line', 'label' => 'Netbanking'],
                  ['value' => 'google_pay', 'icon' => 'ri-google-fill', 'label' => 'GPay'],
                  ['value' => 'paytm', 'icon' => 'ri-wallet-line', 'label' => 'Paytm'],
                  ['value' => 'wallet', 'icon' => 'ri-wallet-3-line', 'label' => 'Others'],
                ];
              @endphp
              @foreach($methods as $method)
              <label class="recharge-pay-option">
                <input type="radio" name="payment_method" value="{{ $method['value'] }}" {{ $loop->first ? 'checked' : '' }}>
                <span class="recharge-pay-card">
                  <i class="{{ $method['icon'] }}"></i>
                  <span>{{ $method['label'] }}</span>
                </span>
              </label>
              @endforeach
            </div>
          </div>
        </div>
      </form>

      {{-- Footer outside scrollable body — always visible --}}
      <div class="recharge-modal-footer">
        <p class="recharge-secure-line mb-0">
          <i class="ri-shield-check-line"></i>
          100% secure &amp; encrypted payment
        </p>
        <button type="submit" form="rechargeForm" class="btn btn-pay-secure">
          <i class="ri-lock-line"></i>
          Pay Securely
        </button>
        <button type="button" class="btn btn-recharge-cancel" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<style>
/* —— Recharge modal (scoped) —— */
#rechargeWalletModal .recharge-modal-dialog {
  width: 100%;
  max-width: 480px;
  margin: 0.75rem auto;
  max-height: calc(100vh - 1.5rem);
  /* Prevent BS centered dialog min-height from clipping the footer */
  min-height: 0 !important;
  align-items: center;
}

#rechargeWalletModal .recharge-modal-dialog::before {
  display: none !important;
}

#rechargeWalletModal .recharge-modal {
  border: none;
  border-radius: 16px;
  overflow: hidden;
  max-height: calc(100vh - 1.5rem);
  display: flex;
  flex-direction: column;
  background: #fff;
  box-shadow: var(--apni-shadow-gulf-10, 0 12px 32px rgb(4 28 84 / 0.15));
}

/* Header: slim, brand gradient */
#rechargeWalletModal .recharge-modal-header {
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  padding: 1rem 1.25rem;
  background: linear-gradient(90deg, var(--apni-gulf-blue) 0%, var(--apni-lynch) 100%);
  border: none;
}

#rechargeWalletModal .recharge-modal-header-main {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  min-width: 0;
}

#rechargeWalletModal .recharge-modal-header-icon {
  width: 40px;
  height: 40px;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 10px;
  background: rgba(255, 255, 255, 0.15);
  color: #fff;
  font-size: 1.25rem;
}

#rechargeWalletModal .recharge-modal-title {
  margin: 0;
  font-size: 1.0625rem;
  font-weight: 600;
  color: #fff;
  line-height: 1.3;
}

#rechargeWalletModal .recharge-modal-subtitle {
  font-size: 0.75rem;
  color: rgba(255, 255, 255, 0.78);
  margin-top: 0.125rem;
}

#rechargeWalletModal .recharge-modal-form {
  flex: 1 1 auto;
  min-height: 0;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

#rechargeWalletModal .recharge-modal-body {
  flex: 1 1 auto;
  min-height: 0;
  overflow-x: hidden;
  overflow-y: auto;
  padding: 1rem 1.25rem;
  background: var(--apni-heather-05, #f8f9fc);
  -webkit-overflow-scrolling: touch;
}

#rechargeWalletModal .recharge-balance-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.75rem 1rem;
  margin-bottom: 1rem;
  border-radius: 12px;
  background: #fff;
  border: 1px solid var(--apni-heather-20, #bac2d220);
}

#rechargeWalletModal .recharge-balance-label {
  font-size: 0.8125rem;
  font-weight: 500;
  color: var(--apni-lynch, #647494);
  text-transform: capitalize;
}

#rechargeWalletModal .recharge-balance-value {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--apni-gulf-blue, #041c54);
}

#rechargeWalletModal .recharge-block {
  background: #fff;
  border-radius: 12px;
  padding: 1rem;
  margin-bottom: 0.75rem;
  border: 1px solid var(--apni-heather-20, #bac2d220);
}

#rechargeWalletModal .recharge-block-title {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  margin: 0 0 0.75rem;
  font-size: 0.875rem;
  font-weight: 600;
  color: var(--apni-gulf-blue, #041c54);
}

#rechargeWalletModal .recharge-block-title i {
  color: var(--apni-lynch, #647494);
  font-size: 1rem;
}

#rechargeWalletModal .recharge-amount-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0.5rem;
  margin-bottom: 0.75rem;
}

#rechargeWalletModal .quick-amount-btn {
  border: 1px solid var(--apni-heather-30, #bac2d230);
  border-radius: 10px;
  padding: 0.5rem 0.25rem;
  font-size: 0.8125rem;
  font-weight: 600;
  background: #fff;
  color: var(--apni-gulf-blue, #041c54);
  transition: background 0.15s, border-color 0.15s, color 0.15s;
}

#rechargeWalletModal .quick-amount-btn:hover,
#rechargeWalletModal .quick-amount-btn.is-active {
  background: var(--apni-gulf-blue, #041c54);
  border-color: var(--apni-gulf-blue, #041c54);
  color: #fff;
}

#rechargeWalletModal .recharge-amount-input {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0 0.75rem;
  height: 44px;
  border-radius: 10px;
  border: 1px solid var(--apni-heather-30, #bac2d230);
  background: #fff;
  margin-bottom: 0.5rem;
}

#rechargeWalletModal .recharge-amount-input:focus-within {
  border-color: var(--apni-lynch, #647494);
  box-shadow: 0 0 0 3px var(--apni-lynch-20, #64749420);
}

#rechargeWalletModal .recharge-amount-input-icon {
  color: var(--apni-lynch, #647494);
  font-size: 1.125rem;
  flex-shrink: 0;
}

#rechargeWalletModal .recharge-amount-input .form-control {
  border: none;
  box-shadow: none;
  padding: 0;
  height: auto;
  font-size: 1rem;
  font-weight: 600;
  color: var(--apni-gulf-blue, #041c54);
  background: transparent;
}

#rechargeWalletModal .recharge-amount-input .form-control:focus {
  box-shadow: none;
}

#rechargeWalletModal .recharge-amount-suffix {
  font-size: 0.75rem;
  font-weight: 600;
  color: var(--apni-lynch, #647494);
  flex-shrink: 0;
}

#rechargeWalletModal .recharge-hint {
  font-size: 0.75rem;
  color: var(--apni-lynch, #647494);
}

#rechargeWalletModal .recharge-pay-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 0.5rem;
}

#rechargeWalletModal .recharge-pay-option {
  margin: 0;
  cursor: pointer;
}

#rechargeWalletModal .recharge-pay-option input {
  position: absolute;
  opacity: 0;
  pointer-events: none;
}

#rechargeWalletModal .recharge-pay-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 0.25rem;
  min-height: 64px;
  padding: 0.5rem 0.35rem;
  border-radius: 10px;
  border: 1px solid var(--apni-heather-30, #bac2d230);
  background: #fff;
  font-size: 0.6875rem;
  font-weight: 600;
  color: var(--apni-gulf-blue, #041c54);
  transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
}

#rechargeWalletModal .recharge-pay-card i {
  font-size: 1.25rem;
  color: var(--apni-lynch, #647494);
}

#rechargeWalletModal .recharge-pay-option input:checked + .recharge-pay-card,
#rechargeWalletModal .recharge-pay-card.is-selected {
  border-color: var(--apni-gulf-blue, #041c54);
  background: var(--apni-gulf-10, #041c5410);
  box-shadow: 0 0 0 1px var(--apni-gulf-blue, #041c54);
}

#rechargeWalletModal .recharge-pay-option input:checked + .recharge-pay-card i {
  color: var(--apni-gulf-blue, #041c54);
}

#rechargeWalletModal .recharge-pay-option:hover .recharge-pay-card {
  border-color: var(--apni-lynch, #647494);
}

/* Sticky footer — never clipped */
#rechargeWalletModal .recharge-modal-footer {
  flex-shrink: 0;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  padding: 1rem 1.25rem 1.25rem;
  background: #fff;
  border-top: 1px solid var(--apni-heather-20, #bac2d220);
}

#rechargeWalletModal .recharge-secure-line {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.35rem;
  font-size: 0.75rem;
  color: var(--apni-lynch, #647494);
}

#rechargeWalletModal .recharge-secure-line i {
  color: var(--apni-success, #10b981);
  font-size: 0.875rem;
}

#rechargeWalletModal .btn-pay-secure {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  width: 100%;
  height: 48px;
  margin: 0;
  padding: 0 1.25rem;
  border: none;
  border-radius: 12px;
  font-size: 0.9375rem;
  font-weight: 600;
  color: #fff !important;
  background: linear-gradient(90deg, var(--apni-gulf-blue, #041c54) 0%, var(--apni-lynch, #647494) 100%);
  box-shadow: 0 8px 20px rgb(4 28 84 / 0.22);
  transition: filter 0.15s, transform 0.15s;
}

#rechargeWalletModal .btn-pay-secure:hover,
#rechargeWalletModal .btn-pay-secure:focus {
  color: #fff !important;
  filter: brightness(1.05);
  transform: translateY(-1px);
}

#rechargeWalletModal .btn-recharge-cancel {
  width: 100%;
  padding: 0.35rem;
  border: none;
  background: transparent;
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--apni-lynch, #647494);
}

#rechargeWalletModal .btn-recharge-cancel:hover {
  color: var(--apni-gulf-blue, #041c54);
  background: transparent;
}

@media (max-width: 400px) {
  #rechargeWalletModal .recharge-amount-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}
</style>
