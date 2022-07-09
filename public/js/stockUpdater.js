const stockActual = document.getElementById('stockActual')
const stockModificado = document.getElementById('stockModificado')

$(document).on('keyup', '#stock_cantidad', function() {
    checkCambios($(this))
})

$(document).on('change', '#stock_cantidad', function() {
    checkCambios($(this))
})

function checkCambios(elemento) {
    if (!isNaN(elemento.val()) && elemento.val() !== "") {
        console.log("hola", isNaN(elemento.val()), elemento.val())
        let valorStockModificado = parseInt(stockActual.textContent) + parseInt(elemento.val())

        if (valorStockModificado < 0)
            valorStockModificado = 0

        stockModificado.textContent = valorStockModificado.toString()
    }
}