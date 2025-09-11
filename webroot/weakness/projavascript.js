function populateSelectOptions(selectId, start, end) {
    const selectElement = document.getElementById(selectId);
    for (let i = start; i <= end; i++) {
      const option = document.createElement('option');
      option.value = i;
      option.textContent = i;
      selectElement.appendChild(option);
    }
  }
  
  function isLeapYear(year) {
    return (year % 4 === 0 && year % 100 !== 0) || year % 400 === 0;
  }
  
  function setDayOptions() {
    const yearSelect = document.getElementById('year');
    const monthSelect = document.getElementById('month');
    const daySelect = document.getElementById('day');
    const year = parseInt(yearSelect.value);
    const month = parseInt(monthSelect.value);
  
    daySelect.innerHTML = '';
    const maxDays = [31, 28 + isLeapYear(year), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    for (let i = 1; i <= maxDays[month - 1]; i++) {
      const option = document.createElement('option');
      option.value = i;
      option.textContent = i;
      daySelect.appendChild(option);
    }
  }
  
  function calculateFortuneTelling(year, month, day) {
    // ① 生年月日を年+月+日の合計を計算
    const sumOfBirthDate = year + month + day;
  
    // ② 生年月日を一桁ずつすべて足した合計を計算
    const birthDateStr = year.toString() + month.toString() + day.toString();
    const digits = birthDateStr.split('').map(Number);
    const sumOfDigitsOfBirthDate = digits.reduce((acc, current) => acc + current, 0);
  
    // ③ ①で出た数字を一桁ずつ足した合計を計算
    let tempSum = sumOfBirthDate;
    let sumOfDigits = 0;
  
    while (tempSum > 0) {
      sumOfDigits += tempSum % 10;
      tempSum = Math.floor(tempSum / 10);
    }
  
    // 才能の計算
let talent = sumOfDigitsOfBirthDate;
if (talent % 22 === 0) {
  talent = 0;
} else {
  while (talent >= 22) {
    talent -= 22;
  }
}

  
    // 弱点の計算
let weakness;
if (sumOfDigits === 22) {
  weakness = 0;
} else if (sumOfDigits === 19) {
  weakness = [19, 10];
} else if (sumOfDigits >= 22) {
  weakness = Math.floor(sumOfDigits / 10) + (sumOfDigits % 10);
} else {
  weakness = sumOfDigits;
}
  
    // 天命の計算
    let destiny = sumOfDigits;
    while (destiny >= 10) {
      destiny = Math.floor(destiny / 10) + (destiny % 10);
    }
  
    return {
      talent: talent,
      weakness: weakness,
      destiny: destiny,
    };
  }
  
  
  
  function redirectToResultPage(result) {
    const url = `proresult.html?talent=${result.talent}&weakness=${result.weakness}&destiny=${result.destiny}`;
    window.location.href = url;
  }
  
  function fortuneTelling() {
    const yearSelect = document.getElementById('year');
    const monthSelect = document.getElementById('month');
    const daySelect = document.getElementById('day');
  
    const year = parseInt(yearSelect.value);
    const month = parseInt(monthSelect.value);
    const day = parseInt(daySelect.value);
  
    const result = calculateFortuneTelling(year, month, day);
  
    redirectToResultPage(result);
  }
  
  // Populate year options from 1923 to 2023
  populateSelectOptions('year', 1923, 2025);
  // 初期値を1970年に設定
document.getElementById('year').value = '1970';
  
  // Populate month options from 1 to 12
  populateSelectOptions('month', 1, 12);
  
  // Set day options based on selected year and month
  document.getElementById('year').addEventListener('change', setDayOptions);
  document.getElementById('month').addEventListener('change', setDayOptions);
  
  // 初期化時に日のプルダウンを設定
  setDayOptions();
  