const request = require('supertest'); // Načti knihovnu supertest pro testování HTTP požadavků
const app = require('../app'); // Načti aplikaci z app.js

describe('API Tests', () => {
    describe('GET /api', () => {
        it('should return JSON object', (done) => {
            request(app)
                .get('/api')
                .expect('Content-Type', /json/) // Očekávaný typ obsahu
                .expect(200) // Očekávaný status kód
                .expect((res) => {
                    // Ověření, že vrácený objekt je správný
                    if (res.body.organization !== 'Student Cyber Games') {
                        throw new Error("Organization name doesn't match!");
                    }
                })
                .end(done); // Ukončete test
        });
    });
});
