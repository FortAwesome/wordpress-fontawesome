import path from 'path'
import dotenv from 'dotenv'
import dotenvExpand from "dotenv-expand"
import { accessSync } from 'fs'

const ROOT_DIR = path.resolve(__dirname, '../../../..')

const envFile = process.env.CI === 'true' ? '.env.ci' : '.env.local'

dotenvExpand.expand(
  dotenv.config({ path: path.resolve(ROOT_DIR, '.env'), override: true })
)

let foundEnvFile = false

try {
  accessSync()
  foundEnvFile = true
} catch {}

if (foundEnvFile) {
  dotenvExpand.expand(
    dotenv.config({ path: path.resolve(ROOT_DIR, envFile), override: true })
  )
}
