const express = require('express')
const app = express()
const port = 3000

app.use('/docs', express.static('../docs'))
app.get('/', (req, res) => res.redirect('/docs'))

app.listen(port, () => console.log(`docsrv listening on port ${port}!`))