<style>
  .login-page {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1fr 44%;
    background: #f8f9fc;
  }

  .login-hero {
    position: relative;
    overflow: hidden;
    padding: 3rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    color: #fff;
    background-image:
      linear-gradient(127.7deg, rgba(4, 28, 84, 0.85) 0%, rgba(100, 116, 148, 0.7) 100%),
      url('https://www.figma.com/api/mcp/asset/ac7bbbdf-028b-4ffc-93e9-79c718f034bf');
    background-size: cover;
    background-position: center;
  }

  .hero-copy h2 {
    max-width: 480px;
    font-size: 3rem;
    line-height: 1.2;
    font-weight: 500;
    color: #ffffff;
    margin: 0 0 1.25rem;
  }

  .hero-copy p {
    max-width: 380px;
    font-size: 1.1rem;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.78);
    margin: 0;
  }

  .login-form-wrapper {
    background: #f8f9fc;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2.5rem;
  }

  .login-form-card {
    width: 100%;
    max-width: 448px;
  }

  .login-form-header h1 {
    margin: 0 0 1.5rem;
    font-size: 2.1rem;
    color: #041C54;
    font-weight: 500;
  }

  .form-group {
    margin-bottom: 1.1rem;
  }

  .form-label {
    display: block;
    margin-bottom: 0.35rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: #041C54;
  }

  .form-input-wrapper {
    position: relative;
  }

  .form-input {
    width: 100%;
    height: 48px;
    border: 1px solid rgba(186, 194, 210, 0.45);
    border-radius: 14px;
    background: #fff;
    padding: 0.8rem 1rem;
    color: #041C54;
    font-size: 0.9rem;
  }

  .form-input::placeholder {
    color: #BAC2D2;
  }

  .form-input:focus {
    outline: none;
    border-color: #647494;
    box-shadow: 0 0 0 3px rgba(100, 116, 148, 0.15);
  }

  .form-input.error {
    border-color: #ef4444;
  }

  .form-error {
    margin-top: 0.4rem;
    font-size: 0.8rem;
    color: #dc2626;
    display: flex;
    gap: 0.4rem;
    align-items: center;
  }

  .submit-btn {
    width: 100%;
    height: 48px;
    border: 0;
    border-radius: 14px;
    color: #fff;
    font-size: 0.95rem;
    font-weight: 500;
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.2), 0 4px 6px rgba(4, 28, 84, 0.2);
    margin-top: 0.5rem;
  }

  .submit-btn:hover {
    filter: brightness(1.03);
  }

  .login-alert {
    margin: 0 0 1rem;
    border-radius: 12px;
    padding: 0.85rem 1rem;
    font-size: 0.85rem;
  }

  .login-alert.success {
    border: 1px solid #bbf7d0;
    background: #f0fdf4;
    color: #047857;
  }

  .auth-back-link {
    text-align: center;
    margin-top: 1.2rem;
    font-size: 0.9rem;
  }

  .auth-back-link a {
    color: #647494;
    text-decoration: none;
  }

  @media (max-width: 1080px) {
    .login-page {
      grid-template-columns: 1fr;
    }

    .login-hero {
      min-height: 280px;
      padding: 2rem;
    }

    .hero-copy h2 {
      font-size: 2rem;
    }

    .login-form-wrapper {
      min-height: auto;
      padding: 2rem 1rem 2.5rem;
    }
  }
</style>
