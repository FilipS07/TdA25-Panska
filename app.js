const express = require('express');  
const path = require('path');        
const app = express();               


app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'Public/index.html'));
});

app.get('/api', (req, res) => {
    res.json({ organization: 'Student Cyber Games' });
});

const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Server běží na http://localhost:${PORT}`);
});
