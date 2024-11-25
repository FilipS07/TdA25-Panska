// test/api.test.js
const request = require('supertest');
const app = require('../app');  // Cesta k vaší Express aplikaci (app.js)

describe('API Tests', () => {
    describe('GET /', () => {
        it('should return "Hello, world!"', (done) => {
            request(app)
                .get('/') // Odesíláme GET požadavek na '/'
                .expect('Content-Type', /text/) // Očekáváme, že odpovědí bude text
                .expect(200) // Očekáváme status kód 200 (OK)
                .expect('Hello, world!', done); // Ověření, že obsah odpovědi je správný
        });
    });
});
