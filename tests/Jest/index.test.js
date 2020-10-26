const lib = require('../../public/js/productsRequest')

// describe('Funções com Promise', () =>{
//    test('Validando o combo de unidades', () => {
//         lib.comboMeasure().then((response) => {
//            console.log(response);
//         });
//    });
// });

describe('Funções sem ajax', () =>{
    test('Verifica se o número é par.', () => {
        expect(lib.verifyEvenNumber(1500)).toBe(true)
    });
});
