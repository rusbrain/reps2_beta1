export const getSmiles = (url) => {
    return new Promise((resolve, reject) => {
      
        axios.get(url)
        .then(function (response) {           
            if(response.data.status == 'ok') {                            
                return resolve(response.data.smiles);
            }
            return reject([]);
        })
        .catch(function (error) {
            reject(false)
        });
    });
};

export const getImages = (url) => {
    return new Promise((resolve, reject) => {
      
        axios.get(url)
        .then(function (response) {           
            if(response.data.status == 'ok') {                            
                return resolve(response.data.images);
            }
            return reject([]);
        })
        .catch(function (error) {
            reject(false)
        });
    });
};

export const getChatUsers = (url) => {
    return new Promise ((resolve, reject) => {
        axios.get(url)
        .then(function (response) {
            if(response.data.status == 'ok') {
                return resolve(response.data.users)
            }
            return reject([])
        })
        .catch(function (error) {
            reject(false)
        })
    });
}
