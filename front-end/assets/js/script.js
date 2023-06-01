//fetch details
  function verifyCoupon(couponCode){
    
    const response = fetch(location.protocol+'//'+location.host+'/devplugin/wp-json/couponverification/v1/code/'+couponCode);
    response.then(res =>
        res.json()
    ).then(data => {
        document.querySelector('.loader').style.display = 'none';
          if (data.result) {
            document.querySelector('p#message').classList.add('text-success');
            document.querySelector('p#message').innerHTML = '"'+couponCode+'" is a '+data.message;
          } else {
            document.querySelector('p#message').classList.add('text-error');
            document.querySelector('p#message').innerHTML = '"'+couponCode+'" is a '+data.message;
          }
        })
        .catch(err => {
            document.querySelector('.loader').style.display = 'none';            
            document.querySelector('p#message').innerHTML = err;
          });
   }


//call function
document.querySelector('form#coupon-verification').onsubmit = function(e){
    e.preventDefault();
    document.querySelector('.loader').style.display = 'inline-block';
    let couponCode = document.querySelector('input#coupon_code').value;
    if( couponCode.length>0) {
    verifyCoupon(document.querySelector('input#coupon_code').value);
    }
};


//remove disabled attr
document.querySelector('input#coupon_code').onkeyup = (e)=>{
    document.querySelector('p#message').innerHTML = '';
    document.querySelector('p#message').classList.remove('text-success');
    document.querySelector('p#message').classList.remove('text-error');
if(e.target.value.length>0){
    document.querySelector('button#submit').removeAttribute('disabled');
}
};