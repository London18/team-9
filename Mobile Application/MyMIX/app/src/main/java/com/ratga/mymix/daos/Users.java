package com.ratga.mymix.daos;
import com.ratga.mymix.RetrofitInstance;
import com.ratga.mymix.models.User;

import java.util.List;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.http.GET;
import retrofit2.http.Query;
import retrofit2.http.POST;
import retrofit2.http.Body;

interface UserService
{
	@GET("Users.php?cmd=getUsers")
	Call<List<User>> getUsers();

	@GET("Users.php?cmd=getUsersByUsernamePassword")
	Call<List<User>> getUsersByUsernamePassword(@Query("username")String username, @Query("password")String password);

	@GET("Users.php?cmd=getUsersByUserId")
	Call<List<User>> getUsersByUserId(@Query("userId")Integer  userId);

	@POST("Users.php?cmd=addUser")
	Call<User> addUser(@Body User user);

}

public class Users
{
	public static List<User> getUsers(Call<List<User>> call)
	{
		List<User> users;

		users = null;

		try
		{
			users = call.execute().body();
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}

		return users;

	}
	public static List<User> getUsers()
	{
		List<User> users;
		UserService service;
		Call<List<User>> call;

		users = null;

		service = RetrofitInstance.GetRetrofitInstance().create(UserService.class);
		try
		{
			call = service.getUsers();
			users = getUsers(call);
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}

		return users;

	}

	public static List<User> getUsersByUsernamePassword(String username, String password)
	{
		List<User> users;
		UserService service;
		Call<List<User>> call;

		users = null;

		service = RetrofitInstance.GetRetrofitInstance().create(UserService.class);
		try
		{
			call = service.getUsersByUsernamePassword(username, password);
			users = getUsers(call);
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}

		return users;

	}

	public static List<User> getUsersByUserId(Integer  userId)
	{
		List<User> users;
		UserService service;
		Call<List<User>> call;

		users = null;

		service = RetrofitInstance.GetRetrofitInstance().create(UserService.class);
		try
		{
			call = service.getUsersByUserId(userId);
			users = getUsers(call);
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}

		return users;

	}


	public static void getUsers(Call<List<User>> call, Callback<List<User>> callback)
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
	public static void getUsers(Callback<List<User>> callback)
	{
		List<User> users;
		UserService service;
		Call<List<User>> call;

		users = null;

		service = RetrofitInstance.GetRetrofitInstance().create(UserService.class);
		try
		{
			call = service.getUsers();
			getUsers(call, callback);
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}


	}

	public static void getUsersByUsernamePassword(String username, String password, Callback<List<User>> callback)
	{
		List<User> users;
		UserService service;
		Call<List<User>> call;

		users = null;

		service = RetrofitInstance.GetRetrofitInstance().create(UserService.class);
		try
		{
			call = service.getUsersByUsernamePassword(username, password);
			getUsers(call, callback);
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}


	}

	public static void getUsersByUserId(Integer  userId, Callback<List<User>> callback)
	{
		List<User> users;
		UserService service;
		Call<List<User>> call;

		users = null;

		service = RetrofitInstance.GetRetrofitInstance().create(UserService.class);
		try
		{
			call = service.getUsersByUserId(userId);
			getUsers(call, callback);
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}


	}


	public static User addUser(User user)
	{
		UserService service;
		Call<User> call;


		service = RetrofitInstance.GetRetrofitInstance().create(UserService.class);
		try
		{
			call = service.addUser(user);
			user = call.execute().body();
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}

		return user;

	}

	public static void addUser(User user, Callback<User> callback)
	{
		UserService service;
		Call<User> call;


		service = RetrofitInstance.GetRetrofitInstance().create(UserService.class);
		try
		{
			call = service.addUser(user);
			call.enqueue(callback);
		}
		catch(Exception ee)
		{
			System.out.println(ee.getMessage());
		}

	}


}
