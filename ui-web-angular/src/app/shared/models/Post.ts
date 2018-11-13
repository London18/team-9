export class Post {
    title: string;
    excerpt: string;
    imageUrl: string;
    articleLink: string;

    constructor(title, excerpt, imageUrl, articleLink) {
        this.title = title;
        this.excerpt = excerpt;
        this.imageUrl = imageUrl;
        this.articleLink = articleLink;
    }
}