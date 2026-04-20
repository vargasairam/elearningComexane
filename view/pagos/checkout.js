// This is your test publishable API key.
const stripe = Stripe("pk_test_51MmJTOGuTfIl032MCUof5RcMfmNgKRVGS3NMWUQOd7TAjJfJupvI2cNBgynNNAsQQnsdTRGppzS9itlVfLR45D4a00GxaW2FWq");

// The items the customer wants to buy
const purchase = [{
   id: "xl-tshirt",
   name:"ana",
   price: 2000
  }];

   // Create an instance of Elements.
   var elements = stripe.elements();

   // Custom styling can be passed to options when creating an Element.
   // (Note that this demo uses a wider set of styles than the guide below.)
   var style = {
     base: {
       color: '#32325d',
       lineHeight: '18px',
       fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
       fontSmoothing: 'antialiased',
       fontSize: '16px',
       '::placeholder': {
         color: '#aab7c4'
       }
     },
     invalid: {
       color: '#fa755a',
       iconColor: '#fa755a'
     }
   };

   // Create an instance of the card Element.
   var card = elements.create('card', {style: style});

   // Add an instance of the card Element into the `card-element` <div>.
   card.mount('#card-element');

   // Handle real-time validation errors from the card Element.
   card.addEventListener('change', function(event) {
     var displayError = document.getElementById('card-errors');
     if (event.error) {
       displayError.textContent = event.error.message;
     } else {
       displayError.textContent = '';
     }
   });
document.querySelector("button").disable = true;

fetch("create.php", {
    method: "POST",
    headers: { 
      "Content-Type": "application/json" 
    },
    body: JSON.stringify({ purchase }),
  }).then(function(results){
    return results.json();
  })
  .then(function(data){
    var elements = stripe.elements();

    var style = {
      base: {
        color: '#32325d',
        lineHeight: '18px',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
          color: '#aab7c4'
        }
      },
      invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
      }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});
    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');
    card.on("change",  function(event){
      document.querySelector("#submit").disable = event.empty;
      document.querySelector("#card-error").textContent = event.error ? event.error.message:"";
    });

    var form = document.getElementById('payment-form');
      form.addEventListener('submit', function(event) {
        event.preventDefault();
        payWithCard(stripe, card, data.clientSecret);
      });
  });

  var payWithCard = function(stripe, card, clientSecret){
    loading(true);
    stripe.confirmCardPayment(clientSecret, {
      payment_method : {
        card:card
      }
    })
    .then(function(result){
      if(result.error){
        showError(result.error.message);
      }else{
        orderComplete(result.paymentIntent.id);
        console.log(result);
      }
    });
  };

var orderComplete = function(paymentIntentId){
  loading(false);
  document
  .querySelector(".result-message a")
  .setAttribute("href", "https://dashboard.stripe.com/test/payments/" + paymentIntentId);

  document.querySelector("result-message").classList.remove("hidden");
  document.querySelector("button").disable = true;
};

var showError = function(errorMsgText){
  loading(false);
  var errorMsgText = document.querySelector("#card-error");
  errorMsgText.textContent = errorMsgText;
  setTimeout(function(){
    errorMsgText.textContent = "";
  });
}

var loading = function(isLoading) {
  if (isLoading) {
    // Disable the button and show a spinner
    document.querySelector("#submit").disabled = true;
    document.querySelector("#spinner").classList.remove("hidden");
    document.querySelector("#button-text").classList.add("hidden");
  } else {
    document.querySelector("#submit").disabled = false;
    document.querySelector("#spinner").classList.add("hidden");
    document.querySelector("#button-text").classList.remove("hidden");
  }
}


     

