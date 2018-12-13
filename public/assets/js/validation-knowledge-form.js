const submitButton = document.querySelector('input[type="submit"]')

submitButton.addEventListener('click', e => {
  const knowledgeValue = document.getElementById('knowledge').value
  const percentageValue = document.getElementById('percentage').value
  if (!knowledgeValue || percentageValue == 0) {
    e.preventDefault()
    alert('Llena los campos necesarios')
  }
})
