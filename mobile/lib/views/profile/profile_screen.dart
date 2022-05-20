import 'package:erasmus_helper/blocs/profile_bloc/profile_bloc.dart';
import 'package:erasmus_helper/blocs/profile_bloc/profile_event.dart';
import 'package:erasmus_helper/models/user.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../../blocs/profile_bloc/profile_state.dart';

class ProfileScreen extends StatelessWidget {
  final ProfileBloc _profileBloc = ProfileBloc();
  UserModel? _profile;
  final TextEditingController _descriptionController = TextEditingController();
  final TextEditingController _fNameController = TextEditingController();
  final TextEditingController _lNameController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    _profileBloc.add(FetchProfileEvent());
    return Scaffold(
      appBar: AppBar(
        title: const Text("Profile"),
        actions: [
          IconButton(
              onPressed: () => _profileBloc.add(EditProfileEvent()),
              icon: const Icon(
                Icons.edit,
              ))
        ],
      ),
      body: BlocProvider(
        create: (_) => _profileBloc,
        child:
            BlocBuilder<ProfileBloc, ProfileState>(builder: (context, state) {
              if (state is ProfileFetchedState) {
            _profile = state.profile;
          }
          if (state is ProfileFetchedState || state is ProfileEditingState) {
            return Container(
                padding: const EdgeInsets.all(15.0),
                child: SingleChildScrollView(
                  child: Column(
                    children: [
                      _buildProfileBanner(
                          state is ProfileEditingState,
                          _profile?.fName ?? "",
                          _profile?.lName ?? "",
                          _profile?.countryCode ?? "",
                          _profile?.countryCode ?? ""),
                      const SizedBox(
                        height: 40.0,
                      ),
                      Column(
                        children: [
                          _buildInfoListTile(Icons.school_rounded,
                              _profile?.erasmusFaculty ?? ""),
                          _buildInfoListTile(
                              Icons.phone, _profile?.phone ?? ""),
                          _buildInfoListTile(
                              Icons.whatsapp_rounded, _profile?.whatsapp ?? ""),
                          _buildInfoListTile(
                              Icons.facebook_rounded, _profile?.facebook ?? "")
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
                ));
          } else {
                return const Center(
                  child: CircularProgressIndicator(),
                );
              }
            }),
      ),
    );
  }

  Row _buildProfileBanner(bool editing, String fname, String lname,
      String country, String description) {
    _descriptionController.text = description;
    _fNameController.text = fname;
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        const CircleAvatar(
          backgroundImage: AssetImage("assets/avatar.jpg"),
          radius: 60,
        ),
        const SizedBox(
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
                  TextField(
                    controller: _fNameController,
                    readOnly: !editing,
                    decoration: InputDecoration(
                        labelText: editing ? "First Name" : "",
                        border: InputBorder.none),
                    style: const TextStyle(
                        fontWeight: FontWeight.bold, fontSize: 18.0),
                  ),
                  const SizedBox(
                    width: 10.0,
                  ),
                  _getFlag(country)
                ],
              ),
              const SizedBox(
                height: 10.0,
              ),
              TextField(
                controller: _descriptionController,
                readOnly: !editing,
                decoration: InputDecoration(
                    labelText: editing ? "Description" : "",
                    border: InputBorder.none),
              ),
              const SizedBox(
                height: 10.0,
              ),
            ],
          ),
        ),
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
        const SizedBox(
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
        style: const TextStyle(color: Colors.white),
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
        const SizedBox(
          height: 15.0,
        )
      ],
    );
  }
}
