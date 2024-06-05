import dotenv from 'dotenv'
import path from 'path'

const ROOT_DIR = path.resolve(__dirname, '../../../..')

dotenv.config({ path: path.resolve(ROOT_DIR, '.env') })
dotenv.config({ path: path.resolve(ROOT_DIR, '.env.local') })
