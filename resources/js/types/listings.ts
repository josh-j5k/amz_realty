export type Query = {
    location: string | null,
    status: string,
    price: {
        min: string,
        max: string
    },
    property_type: string[]
}

export type Listing = {
    description: string,
    id: string,
    location: string,
    price: number,
    property_status: string,
    property_type: string,
    title: string,
    listing_image: string[]
}
export type Listings = {
    data: Array<Listing>
}
export type form = {
    location?: string,
    status?: string,
    price?: string,
    property_type: string,
}