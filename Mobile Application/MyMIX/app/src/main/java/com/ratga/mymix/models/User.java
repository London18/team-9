package com.ratga.mymix.models;
import android.os.Parcel;
import android.os.Parcelable;

import com.stfalcon.chatkit.commons.models.IUser;

import java.util.Date;

public class User implements Parcelable, IUser {
    private Integer  userId;
    private String nickname;
    private String username;
    private String password;
    private Integer  age;
    private String email;
    private Date creationTime;

    public Integer  getUserId()
    {
        return this.userId;
    }

    public void setUserId(Integer  userId)
    {
        this.userId = userId;
    }

    public String getNickname()
    {
        return this.nickname;
    }

    public void setNickname(String nickname)
    {
        this.nickname = nickname;
    }

    public String getUsername()
    {
        return this.username;
    }

    public void setUsername(String username)
    {
        this.username = username;
    }

    public String getPassword()
    {
        return this.password;
    }

    public void setPassword(String password)
    {
        this.password = password;
    }

    public Integer  getAge()
    {
        return this.age;
    }

    public void setAge(Integer  age)
    {
        this.age = age;
    }

    public String getEmail()
    {
        return this.email;
    }

    public void setEmail(String email)
    {
        this.email = email;
    }

    public Date getCreationTime()
    {
        return this.creationTime;
    }

    public void setCreationTime(Date creationTime)
    {
        this.creationTime = creationTime;
    }


    public User(String nickname, String username, String password, Integer  age, String email)
    {
        this.nickname = nickname;
        this.username = username;
        this.password = password;
        this.age = age;
        this.email = email;
    }

    public User()
    {
        this(
                "Test", //Nickname
                "Test", //Username
                "Test", //Password
                0, //Age
                "Test" //Email
        );
        this.userId = 0;
        this.creationTime = new Date(0);

    }


    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeValue(this.userId);
        dest.writeString(this.nickname);
        dest.writeString(this.username);
        dest.writeString(this.password);
        dest.writeValue(this.age);
        dest.writeString(this.email);
        dest.writeLong(this.creationTime != null ? this.creationTime.getTime() : -1);
    }

    protected User(Parcel in) {
        this.userId = (Integer) in.readValue(Integer.class.getClassLoader());
        this.nickname = in.readString();
        this.username = in.readString();
        this.password = in.readString();
        this.age = (Integer) in.readValue(Integer.class.getClassLoader());
        this.email = in.readString();
        long tmpCreationTime = in.readLong();
        this.creationTime = tmpCreationTime == -1 ? null : new Date(tmpCreationTime);
    }

    public static final Parcelable.Creator<User> CREATOR = new Parcelable.Creator<User>() {
        @Override
        public User createFromParcel(Parcel source) {
            return new User(source);
        }

        @Override
        public User[] newArray(int size) {
            return new User[size];
        }
    };

    @Override
    public String getId() {
        return String.valueOf(userId);
    }

    @Override
    public String getName() {
        return username;
    }

    @Override
    public String getAvatar() {
        return null;
    }
}
