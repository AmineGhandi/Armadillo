(function() {
  const numbers = {
  0: "zero", 1: "un", 2: "deux", 3: "trois", 4: "quatre", 5: "cinq", 6: "six", 7: "sept", 8: "huit", 9: "neuf", 10: "dix", 11: "onze", 12: "douze", 13: "treize", 14: "quatorze", 15: "quinze", 16: "seize", 17: "dix-sept", 18: "dix-huit", 19: "dix-neuf", 20: "vingt", 30: "trente", 40: "quarante", 50: "cinqante", 60: "soixante", 70: "soixante-dix", 80: "quatre-vingts", 90: "quatre-vingt-dix"
};
const numberScales = [
  '', '', 'mille', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion', 'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecilion', 'tredecilion', 'quattuordecilion', 'quindecilion', 'sexdecillion', 'septendecilion', 'octodecilion', 'novemdecilion', 'vigintilion'
];

const convertNumberToString = amount => {
  let result = '';
  let isString = typeof amount === 'string' || amount instanceof String;
  
  if (isNaN(amount)) {
    return `'${amount}' is not a valid number.`;
  }
  if (!isNaN(amount) && !isString && amount > Number.MAX_SAFE_INTEGER) {
    return `'${amount}' is past the bounds of MAX_SAFE_INTEGER. Please pass in the number wrapped in quotes (ex: '954.34') for an accurate conversion.`;
  }
  
  const amountString = amount.toString();  
  const splitAmountArray = amountString.split('.');
  const amountIntegerString = splitAmountArray[0];

  const tripleStack = [];
  
  for (let i = amountIntegerString.length; i > 0; i -= 3) {
    const startIndex = (i - 3) < 0 ? 0 : i - 3;
    const tripleString = amountIntegerString.slice(startIndex, i);
    const tripleNum = parseInt(tripleString, 10);
    
    tripleStack.push(tripleNum);
  }
  
  tripleStack.reverse();
  tripleStack.forEach(function(triple, index) {
    const scalePosition = tripleStack.length - index;
    
    if (triple < 20 ) {
      result += ` ${triple === 0 ? '' : numbers[triple]}`;
    } else if (triple < 100) {
      const tensValue = Math.floor(triple / 10) * 10;
      const onesValue = triple - tensValue;
      if (onesValue === 0) {
        result += ` ${tensValue === 0 ? '' : numbers[tensValue]}`;
      } else {
        result += ` ${numbers[tensValue]}-${numbers[onesValue]}`;
      }
    } else {
      const hundredsValue = Math.floor(triple / 100) * 100;
      const realTensValue = triple - hundredsValue;
      const tensValue = Math.floor(realTensValue / 10) * 10;
      const onesValue = realTensValue - tensValue;
      
      if (hundredsValue > 0 && hundredsValue/100 !== 1 ) {
        result += ` ${numbers[hundredsValue / 100]} cent`;
      }else{
        result += `cent`;
      }
      if (realTensValue < 20 && realTensValue !== 0) {
        result += ` ${numbers[realTensValue]}`;
      } else {
        if (onesValue === 0) {
          
          result += ` ${tensValue === 0 ? '' : numbers[tensValue] }`; 
        } else {
          result += ` ${numbers[tensValue]}-${onesValue === 0 ? '' : numbers[onesValue]}`;
        }
      }
    }
    let scale = numberScales[scalePosition];
    if (scale === undefined) scale = 'bajillion';
    result += ` ${scale}`;
  })

  
  return result;
}

const convertAndDisplay = event => {
  const amount = event.currentTarget.value;
  const output = convertNumberToString(amount);
  const outputContainer = document.getElementById('stringOutput');
  outputContainer.innerHTML = output;
}

const searchInput = document.getElementById('numberInput');
searchInput.addEventListener('change', convertAndDisplay);
searchInput.addEventListener('keyup', convertAndDisplay);

const outputContainer = document.getElementById('stringOutput');
})();
