<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Payment Gateway</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

    body {
      font-family: 'Roboto', sans-serif;
      background: #f3f4f6;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .payment-container {
      background: white;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 15px 30px rgba(0,0,0,0.1);
      max-width: 420px;
      width: 100%;
    }

    h2 {
      margin-bottom: 25px;
      color: #003366;
      text-align: center;
      font-weight: 700;
      letter-spacing: 1.1px;
    }

    form label {
      display: block;
      font-weight: 600;
      margin-bottom: 6px;
      color: #444;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px 14px;
      margin-bottom: 20px;
      font-size: 16px;
      border-radius: 10px;
      border: 1.8px solid #ccc;
      transition: border-color 0.3s ease;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: #003366;
      outline: none;
      box-shadow: 0 0 6px #2a00e655;
    }

    .card-icons {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-bottom: 25px;
      filter: grayscale(40%);
      opacity: 0.7;
      transition: opacity 0.3s ease;
    }

    .card-icons img {
      width: 50px;
      user-select: none;
    }

    .card-icons.active {
      filter: none;
      opacity: 1;
    }

    .payment-methods {
      margin-bottom: 25px;
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    .payment-methods label {
      font-weight: 500;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 6px;
      user-select: none;
      color: #444;
      font-size: 15px;
    }

    .payment-methods input[type="radio"] {
      cursor: pointer;
      width: 18px;
      height: 18px;
    }

    button {
      width: 100%;
      background-color: #003366;
      color: white;
      font-weight: 700;
      font-size: 18px;
      padding: 15px;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      box-shadow: 0 6px 12px rgba(0, 38, 230, 0.5);
    }

    button:hover {
      background-color: #003366;
    }

    .success-message {
      margin-top: 20px;
      padding: 15px;
      background-color: #d4edda;
      border: 1px solid #c3e6cb;
      color: #155724;
      border-radius: 8px;
      display: none;
      text-align: center;
      font-weight: 600;
      font-size: 18px;
    }

    /* Input masks for card number & expiry */
    ::-webkit-input-placeholder {
      color: #bbb;
    }

    /* Responsive */
    @media (max-width: 460px) {
      .payment-container {
        padding: 25px 20px;
      }
    }
  </style>
</head>
<body>

<div class="payment-container">
  <h2>Secure Payment</h2>

  <div class="card-icons" id="card-icons">
    <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" alt="Visa" id="visa" />
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1200px-Mastercard-logo.svg.png" alt="MasterCard" id="mastercard" />
    <img src="https://upload.wikimedia.org/wikipedia/commons/3/30/American_Express_logo.svg" alt="Amex" id="amex" />
  </div>

  <form id="payment-form" method="POST" action="/tripzly_test/make_payment">
    <h2>Payment for Booking #<?= htmlspecialchars($bookingId) ?></h2>
    <p>Total Amount Due: LKR <?= number_format($amount) ?></p>

    <input type="hidden" name="bookingId" value="<?= htmlspecialchars($bookingId) ?>">
    <input type="hidden" name="amount" value="<?= htmlspecialchars($amount) ?>">

    <label>Choose Payment Method</label>
    <div class="payment-methods">
      <label for="method-visa">
        <input type="radio" name="paymentMethod" id="method-visa" value="visa" checked />
        Visa
      </label>
      <label for="method-mastercard">
        <input type="radio" name="paymentMethod" id="method-mastercard" value="mastercard" />
        MasterCard
      </label>
      <label for="method-amex">
        <input type="radio" name="paymentMethod" id="method-amex" value="amex" />
        Amex
      </label>
    </div>

    <label for="card-name">Name on Card</label>
    <input type="text" id="card-name" placeholder="John Doe" required autocomplete="cc-name" />

    <label for="card-number">Card Number</label>
    <input
      type="text"
      id="card-number"
      placeholder="1234 5678 9012 3456"
      maxlength="19"
      required
      autocomplete="cc-number"
      pattern="[\d ]{16,19}"
    />

    <label for="expiry-date">Expiry Date (MM/YY)</label>
    <input
      type="text"
      id="expiry-date"
      placeholder="MM/YY"
      maxlength="5"
      pattern="(0[1-9]|1[0-2])\/\d{2}"
      required
      autocomplete="cc-exp"
    />

    <label for="cvv">CVV</label>
    <input
      type="password"
      id="cvv"
      placeholder="123"
      maxlength="4"
      pattern="\d{3,4}"
      required
      autocomplete="cc-csc"
    />

    <button type="submit">Pay Now</button>
    <?php flash('payment')?>
  </form>

  </div>
</div>

<script>
  const cardNumberInput = document.getElementById('card-number');
  const expiryInput = document.getElementById('expiry-date');
  const cardIcons = document.getElementById('card-icons');
  const visaIcon = document.getElementById('visa');
  const mastercardIcon = document.getElementById('mastercard');
  const amexIcon = document.getElementById('amex');
  const form = document.getElementById('payment-form');

  // Payment method radio buttons
  const paymentMethodRadios = document.querySelectorAll('input[name="paymentMethod"]');

  // Update icon highlight based on selected payment method radio
  paymentMethodRadios.forEach(radio => {
    radio.addEventListener('change', () => {
      updateCardIcon(radio.value);
      updateCardNumberPlaceholder(radio.value);
    });
  });

  // Format card number input with spaces every 4 digits or Amex format 4-6-5
  cardNumberInput.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    // Detect current payment method selection
    const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

    let formattedValue = '';
    if (selectedMethod === 'amex') {
      // Amex format: 4-6-5 digits
      formattedValue = value.substr(0,4);
      if(value.length > 4) formattedValue += ' ' + value.substr(4,6);
      if(value.length > 10) formattedValue += ' ' + value.substr(10,5);
    } else {
      // Visa/Mastercard format: groups of 4 digits
      for (let i = 0; i < value.length; i += 4) {
        if (i + 4 < value.length)
          formattedValue += value.substr(i, 4) + ' ';
        else
          formattedValue += value.substr(i);
      }
    }
    e.target.value = formattedValue.trim();
  });

  // Format expiry date input as MM/YY
  expiryInput.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 2) {
      value = value.substr(0, 2) + '/' + value.substr(2, 2);
    }
    e.target.value = value;
  });

  // Show card icon based on card type
  function updateCardIcon(type) {
    visaIcon.style.filter = 'grayscale(100%) opacity(0.3)';
    mastercardIcon.style.filter = 'grayscale(100%) opacity(0.3)';
    amexIcon.style.filter = 'grayscale(100%) opacity(0.3)';

    if (type === 'visa') visaIcon.style.filter = 'none';
    else if (type === 'mastercard') mastercardIcon.style.filter = 'none';
    else if (type === 'amex') amexIcon.style.filter = 'none';
  }

  // Update card number placeholder based on selected card type
  function updateCardNumberPlaceholder(type) {
    if(type === 'amex') {
      cardNumberInput.placeholder = '1234 567890 12345';
      cardNumberInput.maxLength = 17; // 15 digits + 2 spaces
    } else {
      cardNumberInput.placeholder = '1234 5678 9012 3456';
      cardNumberInput.maxLength = 19; // 16 digits + 3 spaces
    }
    cardNumberInput.value = ''; // Clear input on card type change
  }

  // Initial highlight for default checked radio (Visa)
  updateCardIcon('visa');
  updateCardNumberPlaceholder('visa');

  // Simple Luhn check for card validity
  function isValidCardNumber(cardNum) {
    const digits = cardNum.replace(/\s+/g, '').split('').reverse().map(n => parseInt(n));
    let sum = 0;
    for(let i = 0; i < digits.length; i++) {
      let digit = digits[i];
      if(i % 2 === 1) {
        digit *= 2;
        if(digit > 9) digit -= 9;
      }
      sum += digit;
    }
    return sum % 10 === 0;
  }

  form.addEventListener('submit', function(event) {
    event.preventDefault();

    const cardName = document.getElementById('card-name').value.trim();
    const cardNumber = document.getElementById('card-number').value.trim();
    const expiryDate = document.getElementById('expiry-date').value.trim();
    const cvv = document.getElementById('cvv').value.trim();
    const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

    if (!cardName || !cardNumber || !expiryDate || !cvv) {
      alert('Please fill in all fields.');
      return;
    }

    // Validate card number length and Luhn check
    const numOnly = cardNumber.replace(/\s+/g, '');
    let validLength = false;
    if(selectedMethod === 'amex') {
      validLength = numOnly.length === 15;
    } else {
      validLength = numOnly.length >= 13 && numOnly.length <= 19;
    }
    if (!validLength || !isValidCardNumber(cardNumber)) {
      alert('Invalid card number.');
      return;
    }

    // Validate expiry MM/YY and expiry date not passed
    if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiryDate)) {
      alert('Invalid expiry date format. Use MM/YY');
      return;
    }
    const [month, year] = expiryDate.split('/');
    const expDate = new Date(`20${year}`, month);
    const now = new Date();
    if (expDate < now) {
      alert('Card is expired.');
      return;
    }

    // Validate CVV (3 digits for Visa/Mastercard, 4 for Amex)
    if(selectedMethod === 'amex') {
      if (!/^\d{4}$/.test(cvv)) {
        alert('CVV must be 4 digits for Amex.');
        return;
      }
    } else {
      if (!/^\d{3}$/.test(cvv)) {
        alert('CVV must be 3 digits for Visa/Mastercard.');
        return;
      }
    }

    // All validations passed - simulate payment success

    form.submit();
    updateCardIcon('visa');
    updateCardNumberPlaceholder('visa');
  });
</script>

</body>
</html>
