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
  