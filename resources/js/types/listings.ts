export type Query = {
    location: string | null,
    status: string,
    price: {
        min: string,
        max: string
    },
    property_type: string[]
}
type listingImage = {
    id: string,
    listing_image: string,
    listing_id: string
}
export type ListingData = {
    description: string,
    id: string,
    location: string,
    price: number,
    property_status: string,
    property_type: string,
    title: string,
    listing_image: Array<listingImage>
}
export type Listing = Array<ListingData>
export type form = {
    location?: string,
    status?: string,
    price?: string,
    property_type: string,
}