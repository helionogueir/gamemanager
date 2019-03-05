module.exports = class GroupMembersReduce {

    reduce(rowSet, next) {
        try {
            let data = new Object();
            for (let i = 0, row; row = rowSet[i++];) {
                if (!(data[row.id] instanceof Object)) {
                    data[row.id] = new Object({
                        'id': row.id,
                        'type': row.type,
                        'name': row.name
                    });
                }
                data[row.id]['members'] = (data[row.id]['members'] instanceof Array) ?
                    data[row.id]['members'] : new Array();
                data[row.id]['members'].push(row.teamname);
            }
            next(Object.values(data));
        } catch (err) {
            next(null);
        }
    }

}