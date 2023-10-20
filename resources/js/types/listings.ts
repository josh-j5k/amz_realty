export type Query = {
    location: string | null,
    status: string,
    price: {
        min: string,
        max: string
    },
    property_type: string[]
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
    data: Array<Listing>
}
export type form = {
    location?: string,
    status?: string,
    price?: string,
    property_type: string,
}