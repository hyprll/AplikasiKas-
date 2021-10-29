const id_barcode = document.querySelectorAll('.barcode');
let number = 1;

[...id_barcode].forEach(element => {
    const getData = element.dataset.id_barcode

    JsBarcode(`#barcode-${number}`, `${getData}`, {
        format: "pharmacode",
        lineColor: "#000",
        width: 2,
        height: 50,
        displayValue: false
      });

      number++;
});

