export default class Item {
    public id?: Number
    public name: String = ''
    public link: String = ''
    public priority: String = 'low'
    public comment: String = ''
    public is_reserved: Boolean = false
    public reserved_user_id?: Number

    constructor(attributes: Object = {}) {
        Object.assign(this, attributes)
    }
}
