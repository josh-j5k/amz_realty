export type Query = {
    location: string | null,
    status: string,
    price: {
        min: string,
        max: string
    },
    property_type: string[]
}
type Links = {
    first: string,
    last: string,
    next: string | null,
    prev: string | null
}
export type metaLinks = {
    url: string,
    label: string,
    active: boolean
}
type Meta = {
    links: Array<metaLinks>,
    current_page: number,
    last_page: number,
    path: string,
    per_page: number,
    to: number,
    total: number
}
type Listing = {
    description: string,
    id: string,
    location: string,
    price: number,
    propertyStatus: string,
    propertyType: string,
    title: string,
    listingImage: string[]
}
export type SingleListing = {
    listing: Listing
}
export type Listings = {
    data: Array<Listing>,
    links: Links,
    meta: Meta,

}
export type form = {
    location?: string,
    status?: string,
    price?: string,
    property_type: string,
}