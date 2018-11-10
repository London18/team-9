import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ServerUrl } from './ServerUrl';
import { map } from 'rxjs/operators';
import { Observable } from 'rxjs';
import { PostCategory } from '../shared/models/PostCategory';
import { keyframes } from '@angular/animations';

@Injectable({
  providedIn: 'root'
})
export class ForumService {

  constructor(private httpClient: HttpClient) { }

  public getKeywords(): Observable<string[]> {
    return this.httpClient.get<string[]>(ServerUrl.GetUrl() + "Keywords.php?cmd=getKeywords")
      .pipe(map(keywordStruct => keywordStruct['word']));
  }

  public getCategories(): Observable<Object[]> {
    return this.httpClient.get<Object[]>('https://www.themix.org.uk/wp-json/wp/v2/categories');
  }

  public getPostsByCategoryId(categoryId: number) {
    return this.httpClient.get('https://www.themix.org.uk/wp-json/wp/v2/posts?category=' + categoryId);
  }
}
