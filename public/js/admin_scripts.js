/**Get all smiles for HTML text editor*/
function getAllSmiles() {
    var path = 'emoticons/smiles/';
    var smile = 's';
    var extension = '.gif';
    var qty = 63;
    var smilesObject = {};
    var key;
    var result;

    for (var i = 0; i <= qty; i++) {
        key = ':'+ smile + i+':';
        result = path + smile + i + extension;
        smilesObject[key] = result;
    }
    return smilesObject
}
/**Get additional smiles for HTML text editor*/
function getMoreSmiles() {
    var path = 'emoticons/smiles/';
    var smilesObject = {
        ':silver:': path + 'silver.png',
        ':terran:': path + 'terran.gif',
        ':zerg:': path + 'zerg.gif',
        ':gold:': path + 'gold.png',
        ':protoss:': path + 'protoss.gif'
    };
    return smilesObject
}