<style>
/* Wallet — Apni Psychology theme (see resources/css/apni-theme-tokens.css) */

.page-header {
    background: var(--apni-gulf-blue);
    border-radius: 16px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.page-header::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
}

.header-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    backdrop-filter: blur(10px);
}

.page-header h4 {
    color: white;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.page-header p {
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 0;
    position: relative;
    z-index: 1;
}

.balance-card {
    background: white;
    border: none;
    border-radius: 16px;
    box-shadow: var(--apni-shadow-gulf-05);
    overflow: hidden;
}

.balance-card-header {
    background: var(--apni-gulf-blue);
    padding: 2rem;
    position: relative;
    overflow: hidden;
}

.balance-card-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -30%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.wallet-icon-large {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    backdrop-filter: blur(10px);
}

.wallet-icon-large i {
    font-size: 2.5rem;
    color: white;
}

.balance-label {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.balance-amount {
    color: white;
    font-size: 3rem;
    font-weight: 800;
    line-height: 1;
}

.balance-card-body {
    padding: 1.5rem;
}

.btn-recharge,
.btn-empty-recharge {
    width: 100%;
    background: var(--apni-gulf-blue);
    border: none;
    color: white;
    padding: 1rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    box-shadow: var(--apni-shadow-gulf-10);
}

.btn-empty-recharge {
    width: auto;
    padding: 0.75rem 2rem;
}

.btn-recharge:hover,
.btn-empty-recharge:hover {
    background: var(--apni-lynch);
    transform: translateY(-2px);
    color: white;
    box-shadow: var(--apni-shadow-lynch-10);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.stat-card {
    background: white;
    border: none;
    border-radius: 16px;
    box-shadow: var(--apni-shadow-gulf-05);
    padding: 1.25rem;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
}

.stat-card.credit::before { background: var(--apni-success); }
.stat-card.debit::before { background: var(--apni-danger); }
.stat-card.transactions::before { background: var(--apni-info); }
.stat-card.monthly::before { background: var(--apni-warning); }

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--apni-shadow-gulf-10);
}

.stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
}

.stat-icon.credit { background: var(--apni-success-soft); color: var(--apni-success); }
.stat-icon.debit { background: var(--apni-danger-soft); color: var(--apni-danger); }
.stat-icon.transactions { background: var(--apni-info-soft); color: var(--apni-info); }
.stat-icon.monthly { background: var(--apni-warning-soft); color: var(--apni-warning); }

.stat-label {
    color: var(--apni-lynch);
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.stat-value { font-size: 1.35rem; font-weight: 700; }
.stat-value.credit { color: var(--apni-success); }
.stat-value.debit { color: var(--apni-danger); }
.stat-value.transactions { color: var(--apni-info); }
.stat-value.monthly { color: var(--apni-warning); }

.transactions-card {
    background: white;
    border: none;
    border-radius: 16px;
    box-shadow: var(--apni-shadow-gulf-05);
    overflow: hidden;
}

.transactions-header {
    background: var(--apni-heather-05);
    padding: 1.25rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid var(--apni-heather-20);
}

.transactions-header h5 {
    font-weight: 700;
    color: var(--apni-gulf-blue);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.transactions-header h5 i {
    color: var(--apni-lynch);
}

.btn-view-all {
    background: transparent;
    color: #041c54;
    border: 2px solid #041c54;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-view-all:hover {
    background: #041c54;
    border-color: #041c54;
    color: #fff;
}

.txn-date { font-weight: 600; color: var(--apni-gulf-blue); }
.txn-time { color: var(--apni-lynch); font-size: 0.8rem; }

.txn-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.txn-icon.credit { background: var(--apni-success-soft); color: var(--apni-success); }
.txn-icon.debit { background: var(--apni-danger-soft); color: var(--apni-danger); }

.txn-description { font-weight: 600; color: var(--apni-gulf-blue); }
.txn-id { color: var(--apni-lynch); font-size: 0.75rem; font-family: monospace; }

.txn-type-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.txn-type-badge.credit { background: var(--apni-success-soft); color: var(--apni-success); }
.txn-type-badge.debit { background: var(--apni-danger-soft); color: var(--apni-danger); }

.txn-amount { font-weight: 700; font-size: 1rem; }
.txn-amount.credit { color: var(--apni-success); }
.txn-amount.debit { color: var(--apni-danger); }

.txn-balance { font-weight: 600; color: var(--apni-gulf-blue); }

.payment-method-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    background: var(--apni-info-soft);
    color: var(--apni-info);
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state-icon {
    width: 100px;
    height: 100px;
    background: var(--apni-gulf-10);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.empty-state-icon i {
    font-size: 2.5rem;
    color: var(--apni-lynch);
}

.empty-state h5 {
    color: var(--apni-gulf-blue);
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: var(--apni-lynch);
    margin-bottom: 1.5rem;
}

.btn-back {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-back:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    color: white;
}

.balance-card-inline {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--apni-shadow-gulf-05);
    margin-bottom: 2rem;
    border: 1px solid var(--apni-heather-20);
}

.balance-card-inline .balance-label {
    font-size: 0.875rem;
    color: var(--apni-lynch);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.balance-card-inline .balance-amount {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--apni-gulf-blue);
}

.transactions-table thead th {
    background: var(--apni-heather-05);
    color: var(--apni-gulf-blue);
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 18px 20px;
    border: none;
}

.transactions-table tbody td {
    padding: 18px 20px;
    border-bottom: 1px solid var(--apni-heather-10);
    vertical-align: middle;
    color: var(--apni-gulf-blue);
    font-size: 0.9rem;
}

.badge-credit {
    background: var(--apni-success-soft);
    color: var(--apni-success);
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.badge-debit {
    background: var(--apni-danger-soft);
    color: var(--apni-danger);
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.amount-credit { color: var(--apni-success); font-weight: 700; font-size: 1.1rem; }
.amount-debit { color: var(--apni-danger); font-weight: 700; font-size: 1.1rem; }

.txn-id-badge {
    font-family: monospace;
    font-weight: 600;
    color: var(--apni-gulf-blue);
    background: var(--apni-gulf-10);
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
}

@media (max-width: 768px) {
    .page-header { padding: 1.5rem; }
    .balance-amount { font-size: 2.25rem; }
    .stats-grid { gap: 0.75rem; }
    .stat-card { padding: 1rem; }
    .stat-value { font-size: 1.1rem; }
}
</style>
