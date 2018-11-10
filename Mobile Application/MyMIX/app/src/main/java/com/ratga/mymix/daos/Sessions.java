package com.ratga.mymix.daos;
import com.ratga.mymix.RetrofitInstance;
import com.ratga.mymix.models.Session;

import java.util.List;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.http.GET;
import retrofit2.http.Query;
import retrofit2.http.POST;
import retrofit2.http.Body;
interface SessionService
{
	@GET("Sessions.php?cmd=getSessions")
	Call<List<Session>> getSessions();
	
	@GET("Sessions.php?cmd=getSessionsBySessionId")
	Call<List<Session>> getSessionsBySessionId(@Query("sessionId")Integer  sessionId);
	
	@POST("Sessions.php?cmd=addSession")
	Call<Session> addSession(@Body Session session);

}

public class Sessions
{
	public static List<Session> getSessions(Call<List<Session>> call)
	{
		List<Session> sessions;
		
		sessions = null;
		
		try
		{
			sessions = call.execute().body();
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}
		
		return sessions;
	
	}
	public static List<Session> getSessions()
	{
		List<Session> sessions;
		SessionService service;
		Call<List<Session>> call;
		
		sessions = null;
		
		service = RetrofitInstance.GetRetrofitInstance().create(SessionService.class);
		try
		{
			call = service.getSessions();
			sessions = getSessions(call);
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}
		
		return sessions;
	
	}
	
	public static List<Session> getSessionsBySessionId(Integer  sessionId)
	{
		List<Session> sessions;
		SessionService service;
		Call<List<Session>> call;
		
		sessions = null;
		
		service = RetrofitInstance.GetRetrofitInstance().create(SessionService.class);
		try
		{
			call = service.getSessionsBySessionId(sessionId);
			sessions = getSessions(call);
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}
		
		return sessions;
	
	}
	
	
	public static void getSessions(Call<List<Session>> call, Callback<List<Session>> callback)
	{
		try
		{
			call.enqueue(callback);
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}
		
	
	}
	public static void getSessions(Callback<List<Session>> callback)
	{
		List<Session> sessions;
		SessionService service;
		Call<List<Session>> call;
		
		sessions = null;
		
		service = RetrofitInstance.GetRetrofitInstance().create(SessionService.class);
		try
		{
			call = service.getSessions();
			getSessions(call, callback);
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}
		
	
	}
	
	public static void getSessionsBySessionId(Integer  sessionId, Callback<List<Session>> callback)
	{
		List<Session> sessions;
		SessionService service;
		Call<List<Session>> call;
		
		sessions = null;
		
		service = RetrofitInstance.GetRetrofitInstance().create(SessionService.class);
		try
		{
			call = service.getSessionsBySessionId(sessionId);
			getSessions(call, callback);
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}
		
	
	}
	
	
	public static Session addSession(Session session)
	{
		SessionService service;
		Call<Session> call;
		
		
		service = RetrofitInstance.GetRetrofitInstance().create(SessionService.class);
		try
		{
			call = service.addSession(session);
			session = call.execute().body();
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}
		
		return session;
	
	}
	
	public static void addSession(Session session, Callback<Session> callback)
	{
		SessionService service;
		Call<Session> call;
		
		
		service = RetrofitInstance.GetRetrofitInstance().create(SessionService.class);
		try
		{
			call = service.addSession(session);
			call.enqueue(callback);
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}
	
	}
	

}
