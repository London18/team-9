import java.util.Arrays;

public class NewArticle {
	public String id;
	public String link;
	public String title;
	public String content;
	public String excerpt;
	public int[] categories;
	public int[] tags;
	public int[] keywords;
	@Override
	public String toString() {
		return "NewArticle [id=" + id + ", link=" + link + ", title=" + title +  ", excerpt="
				+ excerpt + ", categories=" + Arrays.toString(categories) + ", tags=" + Arrays.toString(tags)
				+ ", keywords=" + Arrays.toString(keywords) + "]";
	}
}
