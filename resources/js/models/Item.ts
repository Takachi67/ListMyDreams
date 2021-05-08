export default class Item {
    public name: String = ''
    public link: String = ''
    public priority: String = 'low'
    public comment: String = ''

    constructor(attributes: Object = {}) {
        Object.assign(this, attributes)
    }
}
