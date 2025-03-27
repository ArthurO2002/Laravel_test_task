import eslint from '@eslint/js'
import tseslint from 'typescript-eslint'
import vueParser from 'vue-eslint-parser'
import vuePlugin from 'eslint-plugin-vue'
import prettierConfig from 'eslint-config-prettier'
import prettierPlugin from 'eslint-plugin-prettier'
import globals from 'globals'

export default [
    {
        ignores: [
            '**/node_modules/**',
            '**/dist/**',
            '**/build/**',
            '**/.nuxt/**',
            '**/.vercel/**',
            '**/.next/**'
        ]
    },
    eslint.configs.recommended,
    ...tseslint.configs.recommended,
    ...vuePlugin.configs['flat/recommended'],
    prettierConfig,
    {
        files: ['resources/**/*.{js,jsx,ts,tsx,vue}'],
        languageOptions: {
            globals: {
                ...globals.browser,
                ...globals.node
            },
            parser: vueParser,
            parserOptions: {
                parser: '@typescript-eslint/parser',
                sourceType: 'module',
                ecmaVersion: 'latest',
                extraFileExtensions: ['.vue']
            }
        },
        plugins: {
            prettier: prettierPlugin
        },
        rules: {
            'vue/multi-word-component-names': 'off',

            '@typescript-eslint/no-explicit-any': 'warn',

            'prettier/prettier': ['error', {
                singleQuote: true,
                semi: false,
                trailingComma: 'none',
                endOfLine: 'auto'
            }]
        }
    }
]
