module.exports = {
  env: {
    browser: true,
    es6:     true
  },
  extends: [
    'plugin:vue/essential',
    '@vue/standard'
    // 'standard'
  ],
  /* globals: {
    Atomics: 'readonly',
    SharedArrayBuffer: 'readonly'
  }, */
  parserOptions: {
    ecmaVersion: 2020,
    sourceType:  'module'
  },
  /*  plugins: [
    'vue'
  ], */
  rules: {
    'key-spacing':     ['error', { align: 'value' }],
    'no-multi-spaces': [
      'error',
      {
        exceptions: { ImportDeclaration: true, VariableDeclarator: true }
      }
    ]
  }
}
