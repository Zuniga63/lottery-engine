export default function (number, fractionDigits = 0, style = 'currency', currency = "COP") {
  var formatted = new Intl.NumberFormat('es-CO', {
    style,
    currency,
    minimumFractionDigits: fractionDigits,
  }).format(number);
  return formatted;
}