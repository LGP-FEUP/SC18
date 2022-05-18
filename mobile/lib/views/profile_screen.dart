import 'package:erasmus_helper/blocs/profile_bloc/profile_bloc.dart';
import 'package:erasmus_helper/blocs/profile_bloc/profile_event.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../blocs/profile_bloc/profile_state.dart';

class ProfileScreen extends StatelessWidget {
  final ProfileBloc _profileBloc = ProfileBloc();

  @override
  Widget build(BuildContext context) {
    _profileBloc.add(FetchProfileEvent());
    return Scaffold(
      appBar: AppBar(
        title: const Text("Profile"),
      ),
      body: BlocProvider(
        create: (_) => _profileBloc,
        child:
            BlocBuilder<ProfileBloc, ProfileState>(builder: (context, state) {
          if (state is ProfileFetchedState) {
            String fname = state.profile.fName ?? "";
            String lname = state.profile.lName ?? "";
            String country = state.profile.countryCode ?? "";
            String description = state.profile.description ?? "";
            String faculty = state.profile.erasmusFaculty ?? "";
            String phone = state.profile.phone ?? "";
            String whatsapp = state.profile.whatsapp ?? "";
            String facebook = state.profile.facebook ?? "";
            return Container(
              padding: const EdgeInsets.all(15.0),
              child: Column(
                children: [
                  _buildProfileBanner(fname, lname, country, description),
                  const SizedBox(
                    height: 40.0,
                  ),
                  Column(
                    children: [
                      _buildInfoListTile(Icons.school_rounded, faculty),
                      _buildInfoListTile(Icons.phone, phone),
                      _buildInfoListTile(Icons.whatsapp_rounded, whatsapp),
                      _buildInfoListTile(Icons.facebook_rounded, facebook)
                    ],
                  ),
                  const SizedBox(
                    height: 20.0,
                  ),
                  _buildChipList([
                    "hiking",
                    "music",
                    "sport",
                    "games",
                    "party",
                    "cooking",
                    "surfing",
                    "basketball",
                    "soccer",
                    "karaoke"
                  ])
                ],
              ),
            );
          } else {
            return const Center(
              child: CircularProgressIndicator(),
            );
          }
        }),
      ),
    );
  }

  Row _buildProfileBanner(
      String fname, String lname, String country, String description) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        CircleAvatar(
          backgroundImage: AssetImage("assets/avatar.jpg"),
          radius: 60,
        ),
        SizedBox(
          width: 20.0,
        ),
        Flexible(
            fit: FlexFit.loose,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Row(
                  children: [
                    Text(
                      "$fname $lname",
                      style: TextStyle(
                          fontWeight: FontWeight.bold, fontSize: 18.0),
                    ),
                    SizedBox(
                      width: 10.0,
                    ),
                    _getFlag(country)
                  ],
                ),
                SizedBox(
                  height: 10.0,
                ),
                Text(description),
              ],
            ))
      ],
    );
  }

  Image _getFlag(String countryCode) {
    return Image.asset("assets/flags/$countryCode.png", height: 15.0,
        errorBuilder: (context, error, stackTrace) {
      return Image.asset(
        "assets/flags/eu.png",
        height: 25.0,
      );
    });
  }

  Widget _buildChipList(List<String> labels) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          "Interests",
          style: TextStyle(
              fontWeight: FontWeight.bold,
              fontSize: 18.0,
              color: Colors.blueGrey.shade400),
        ),
        SizedBox(
          height: 5.0,
        ),
        Wrap(
          spacing: 6.0,
          runSpacing: 6.0,
          children: labels.map((label) => _buildChip(label)).toList(),
        ),
      ],
    );
  }

  Widget _buildChip(String label) {
    return Chip(
      label: Text(
        label,
        style: TextStyle(color: Colors.white),
      ),
      elevation: 2.0,
      shadowColor: Colors.grey[60],
      backgroundColor: Colors.blueGrey.shade600,
      padding: EdgeInsets.all(8.0),
    );
  }

  Widget _buildInfoListTile(IconData icon, String content) {
    return Column(
      children: [
        ListTile(
          tileColor: Colors.blueGrey.shade100,
          trailing: Icon(icon),
          title: Text(content),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(15.0),
          ),
        ),
        SizedBox(
          height: 15.0,
        )
      ],
    );
  }
}
