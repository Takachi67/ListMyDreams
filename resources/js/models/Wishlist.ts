import Item from './Item'

export default class Wishlist {
    public id?: Number
    public temp_id?: Number
    public name: String = ''
    public category: String = 'anniversary'
    public sharing_type: String = 'friends'
    public status: String = 'created'
    public expire_at?: Date
    public items: Array<Item> = []
    public border_color: String = '#e3925a'
    public text_color: String = '#000000'
    public line_color: String = '#666666'

    constructor(attributes: Object = {}) {
        Object.assign(this, attributes)
    }
}
