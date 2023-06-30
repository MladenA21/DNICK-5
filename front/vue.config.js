const { defineConfig } = require("@vue/cli-service");
module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
    proxy: {
      "^/api": {
        target: "https://mladen.dnick.ddcode.co",
        changeOrigin: true,
      },
    },
  },
});
