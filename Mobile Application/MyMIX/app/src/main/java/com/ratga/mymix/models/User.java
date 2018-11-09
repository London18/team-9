package com.ratga.mymix.models;

import com.stfalcon.chatkit.commons.models.IUser;

import java.util.Date;

public class User implements IUser {
    private Integer userId;
    private String nickname;
    private String password;
    private Integer age;
    private String email;
    private Date creationTime;

    public Integer getUserId() {
        return this.userId;
    }

    public void setUserId(Integer userId) {
        this.userId = userId;
    }

    public String getNickname() {
        return this.nickname;
    }

    public void setNickname(String nickname) {
        this.nickname = nickname;
    }

    public String getPassword() {
        return this.password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public Integer getAge() {
        return this.age;
    }

    public void setAge(Integer age) {
        this.age = age;
    }

    public String getEmail() {
        return this.email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public Date getCreationTime() {
        return this.creationTime;
    }

    public void setCreationTime(Date creationTime) {
        this.creationTime = creationTime;
    }


    public User(String nickname, String password, Integer age, String email) {
        this.nickname = nickname;
        this.password = password;
        this.age = age;
        this.email = email;
    }

    public User() {
        this(
                "Test", //Nickname
                "Test", //Password
                0, //Age
                "Test" //Email
        );
        this.userId = 0;
        this.creationTime = new Date(0);

    }


    @Override
    public String getId() {
        return String.valueOf(userId);
    }

    @Override
    public String getName() {
        return getName();
    }

    @Override
    public String getAvatar() {
        return null;
    }
}
