const express = require('express');
const app = express();
const port = 3000;

app.use(express.static('public'));

app.use(express.urlencoded({ extended: false}));

app.post('/login', (req, res) => {
    const {stdId, stdPass} = req.body;

    res.send('Login Success');
});

app.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});