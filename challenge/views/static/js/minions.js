const minionsData = [
    {
      image: '/assets/bob.gif',
      quote: 'Quote 1: Banana!'
    },
    {
      image: '/assets/bob2.gif',
      quote: 'Quote 2: Bello!'
    },
    {
        image: '/assets/kevin.gif',
        quote: 'Quote 3: Bello!'
    },   
    {
        image: '/assets/stuart.gif',
        quote: 'Quote 4: Bello!'
    },
  ];
  
  function loadRandomMinion() {
    const randomNumber = Math.floor(Math.random() * minionsData.length);
    const randomMinion = minionsData[randomNumber];
  
    const minionImage = document.getElementById('minion-image');
    const minionQuote = document.getElementById('minion-quote');
  
    minionImage.src = randomMinion.image;
    minionQuote.textContent = randomMinion.quote;
  }
  

  window.addEventListener('load', loadRandomMinion);
  