import webpack from 'webpack';
import path from 'path';
import poststylus from 'poststylus';
import autoprefixer from 'autoprefixer';
import DotenvPlugin from 'webpack-dotenv-plugin';

export default {
	debug: true,
	devtool: 'cheap-module-eval-source-map',
	noInfo: true,
	entry: [
		'eventsource-polyfill',
		'webpack-hot-middleware/client?reload=true',
		'./src/index'
	],
	target: 'web',
	output: {
		path: path.join(__dirname, 'dist'),
		publicPath: '/',
		filename: 'bundle.js'
	},
	devServer: {
		contentBase: './src'
	},
	plugins: [
		new webpack.HotModuleReplacementPlugin(),
		new webpack.NoErrorsPlugin(),
		new webpack.ProvidePlugin({
			$: "jquery",
			jQuery: "jquery"
		}),
		new DotenvPlugin({
			sample: './.env.sample',
			path: './.env'
		})
	],
	resolve: {
		modulesDirectories: ['node_modules', './src'],
		extensions: ['', '.js', '.jsx', '.css', '.styl']
	},
	module: {
		loaders: [
			{test: /\.js$/, exclude: /node_modules/, loader: 'babel'},
			{test: /(\.css)$/, loader: 'style!css'},
			{test: /\.styl$/, loader: 'style-loader!css-loader!stylus-loader'},
			{test: /\.(gif|png|jpe?g|ico)$/, loader: 'url-loader?limit=100000&name=[name]-[hash:6].[ext]'},
			{test: /\.(woff|woff2|svg|ttf|eot|otf)(\?[\s\S]+)?$/, loader: 'file-loader?limit=100000&name=[name].[ext]'}
		]
	},
	stylus: {
		use: [
			poststylus([
				autoprefixer({ browsers: ['last 2 version', '> 1%', 'IE > 8'] })
			])
		]
	}
};