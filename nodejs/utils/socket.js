'use strict';

const moment = require('moment');
const path = require('path');
const fs = require('fs');
const helper = require('./helper');

class Socket {

    constructor(socket) {
        this.io = socket;
    }

    socketEvents() {
        this.io.on('connection', (socket) => {           
            /**
            * get the get messages
            */
            socket.on('getMessages', async () => {                  
                const result = await helper.getMessages();
                if (result === null) {
                    this.io.emit('getMessagesResponse', { result: [] });
                } else {
                    this.io.emit('getMessagesResponse', { result: result });
                }
            });

            /**
            * send the messages to the user
            */
            socket.on('sendMessage', async (response) => { 
                const result = await helper.getMessage({
                    user_id: response.user_id,
                    id: response.id
                });
             
                this.io.emit('addMessageResponse', result);
            });

            socket.on('disconnect', async () => {
               
            });
        });
    }

 
    socketConfig() {
        this.io.use(async (socket, next) => {            
            next();           
        });
        this.socketEvents();
    }
}
module.exports = Socket;
