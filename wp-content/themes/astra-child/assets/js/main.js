console.log("BBAU Frontend Loaded Successfully");
document.querySelectorAll('.search-box input').forEach(input => {
  const defaultText = 'Search';

  input.addEventListener('focus', () => {
    if (input.value === defaultText) {
      input.value = '';
    }
  });

  input.addEventListener('blur', () => {
    if (input.value.trim() === '') {
      input.value = defaultText;
    }
  });
});
