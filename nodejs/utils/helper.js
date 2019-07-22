'user strict';

const path = require('path');
const fs = require('fs');
const request = require('request');

class Helper {
	async addSocketId(userInfo){
		return new Promise((resolve, reject) => {
			try {
				request.post(
					{
						url:process.env.HOST + '/chat/socket_user',
					 	form: userInfo
					}, 
					function(err,httpResponse,body){
						  const response = JSON.parse(body)
						  if(response.status ===  'ok') {
							  return true
						  }
					})
				
			} catch (error) {
				console.warn(error);
				resolve(null);
			}
		})
	}

	async getMessage(params) {
		return new Promise((resolve, reject) => {
			try {
				request.post(
					{
						url:process.env.HOST + '/chat/get_message',
					 	form: params
					}, 
					function(err,httpResponse,body){
						  const response = JSON.parse(body);						 
						  if(response.status ===  'ok') {
							resolve(response.message)
						  }
					})
				
			} catch (error) {
				console.warn(error);
				resolve(null);
			}
		})
	}

	async getMessages() {
		return new Promise((resolve, reject) => {
			try {
				request(process.env.HOST + '/chat/get_messages', function (error, response, body) {				
					resolve(JSON.parse(body))
				})
			} catch (error) {
				console.warn(error);
				resolve(null);
			}
		})

	}

	async mkdirSyncRecursive(directory) {
		var dir = directory.replace(/\/$/, '').split('/');
		for (var i = 1; i <= dir.length; i++) {
			var segment = path.basename('uploads') + "/" + dir.slice(0, i).join('/');
			!fs.existsSync(segment) ? fs.mkdirSync(segment) : null;
		}
	}
}
module.exports = new Helper();
