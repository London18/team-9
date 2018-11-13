import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.Authenticator;
import java.net.HttpURLConnection;
import java.net.InetSocketAddress;
import java.net.MalformedURLException;
import java.net.PasswordAuthentication;
import java.net.Proxy;
import java.net.URL;
import java.net.URLEncoder;
import java.security.cert.Certificate;
import java.util.ArrayList;
import java.util.Collection;

import javax.net.ssl.HttpsURLConnection;
import javax.net.ssl.SSLPeerUnverifiedException;

import com.google.gson.Gson;

import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;

public class Main {

	private final static String USER_AGENT = "Mozilla/5.0";

	public static void main(String[] args) {
		readPosts();
		
	}
	
	public static void readPosts()
	{
		try {
			String url = "https://www.themix.org.uk/wp-json/wp/v2/posts";

			URL obj = new URL(url);
			HttpURLConnection con = (HttpURLConnection) obj.openConnection();

			// optional default is GET
			con.setRequestMethod("GET");

			// add request header
			con.setRequestProperty("User-Agent", USER_AGENT);

			int responseCode = con.getResponseCode();

			BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
			String inputLine;
			StringBuffer response = new StringBuffer();

			while ((inputLine = in.readLine()) != null) {
				response.append(inputLine);
			}
			in.close();

			String jsonString = response.toString();
			//System.out.println(response.toString());
			
			Gson g = new Gson(); 
			Article[] articles = g.fromJson(jsonString, Article[].class);
			NewArticle[] newArticles = new NewArticle[articles.length];
			for(int i = 0; i < articles.length; i++)
			{
				newArticles[i] = myParser(articles[i]); 
				addArticle(newArticles[i]);
				//findKeyWordsAndUploadKeywords(articles[i].content.rendered, articles[i].id);
				//System.out.println(newArticles[i].toString());
			}
		} catch (Exception e) {
			System.out.println(e.getMessage());
		}
	}

	private static void findKeyWordsAndUploadKeywords(String rendered, String id) {
		
		
	}

	private static void addArticle(NewArticle newArticle) {
		try {
			String url = "http://35.242.228.41/Responses.php?cmd=addResponse&name=" + URLEncoder.encode(newArticle.link, "UTF-8");
			URL obj = new URL(url);
			HttpURLConnection con = (HttpURLConnection) obj.openConnection();

			// optional default is GET
			con.setRequestMethod("GET");

			// add request header
			con.setRequestProperty("User-Agent", USER_AGENT);

			int responseCode = con.getResponseCode();

			BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
			String inputLine;
			StringBuffer response = new StringBuffer();

			while ((inputLine = in.readLine()) != null) {
				response.append(inputLine);
			}
			in.close();
		} catch (Exception e) {
			System.out.println(e.getMessage());
		}
		
		//"http://35.242.228.41/Responses.php?cmd=addResponse&name=" + link;
	}

	private static NewArticle myParser(Article article) {
		NewArticle newArticle = new NewArticle();
		newArticle.id = article.id;
		newArticle.link = article.link;		
		return newArticle;
	}

	static int i = 1;
	
	private static int[] findKeyWords(String content) {
		int[] keys = {i++, i++, i++};
		return keys;
	}
}
