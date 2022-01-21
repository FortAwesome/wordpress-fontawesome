const defaultConfig = require('@wordpress/scripts/config/jest-e2e.config')
require('dotenv').config({ path: '../.env' })

process.env.WP_BASE_URL = `http://${process.env.WP_DOMAIN}`
process.env.WP_USERNAME=process.env.WP_ADMIN_USERNAME
process.env.WP_PASSWORD=process.env.WP_ADMIN_PASSWORD

module.exports = defaultConfig;
