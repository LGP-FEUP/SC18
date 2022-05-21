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
  final TextEditingController _countryController = TextEditingController();
  final TextEditingController _facultyController = TextEditingController();
  final TextEditingController _phoneController = TextEditingController();
  final TextEditingController _whatsappController = TextEditingController();
  final TextEditingController _facebookController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    _profileBloc.add(FetchProfileEvent());
    return BlocProvider(
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
                          _profile?.description ?? ""),
                      const SizedBox(
                        height: 40.0,
                      ),
                      state is ProfileFetchedState
                          ? Column(
                              children: [
                                _buildInfoListTile(Icons.school_rounded,
                                    _profile?.erasmusFaculty ?? ""),
                                _buildInfoListTile(
                                    Icons.phone, _profile?.phone ?? ""),
                                _buildInfoListTile(Icons.whatsapp_rounded,
                                    _profile?.whatsapp ?? ""),
                                _buildInfoListTile(Icons.facebook_rounded,
                                    _profile?.facebook ?? "")
                              ],
                            )
                          : Column(
                              children: [
                                _buildEditListTile(_profile?.fName,
                                    _fNameController, "FirstName"),
                                _buildEditListTile(_profile?.lName,
                                    _lNameController, "Last Name"),
                                _buildEditListTile(_profile?.countryCode,
                                    _countryController, "Country"),
                                _buildEditListTile(_profile?.description,
                                    _descriptionController, "Description"),
                                _buildEditListTile(_profile?.erasmusFaculty,
                                    _facultyController, "Faculty"),
                                _buildEditListTile(
                                    _profile?.phone, _phoneController, "Phone"),
                                _buildEditListTile(_profile?.whatsapp,
                                    _whatsappController, "Whatsapp"),
                                _buildEditListTile(_profile?.facebook,
                                    _facebookController, "Facebook")
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
                      ]),
                      state is ProfileEditingState
                          ? ElevatedButton(
                              onPressed: () {
                                _profile!.fName = _fNameController.text;
                                _profile!.lName = _lNameController.text;
                                _profile!.countryCode = _countryController.text;
                                _profile!.description =
                                    _descriptionController.text;
                                _profile!.phone = _phoneController.text;
                                _profile!.whatsapp = _whatsappController.text;
                                _profile!.facebook = _facebookController.text;
                                _profileBloc.add(SubmitProfileEvent(_profile!));
                              },
                              child: Text("Submit"))
                          : ElevatedButton(
                              onPressed: () =>
                                  _profileBloc.add(EditProfileEvent()),
                              child: Text("Edit"))
                    ],
                  ),
                ));
          } else {
            return const Center(
              child: CircularProgressIndicator(),
            );
          }
        }));
  }

  Widget _buildProfileBanner(bool editing, String fname, String lname,
      String country, String description) {
    return !editing
        ? Row(
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
                        Text(
                          "$fname $lname",
                          style: const TextStyle(
                              fontWeight: FontWeight.bold, fontSize: 18),
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
                    Text(description),
                    const SizedBox(
                      height: 10.0,
                    ),
                  ],
                ),
              ),
            ],
          )
        : const CircleAvatar(
            backgroundImage: AssetImage("assets/avatar.jpg"),
            radius: 60,
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
      padding: const EdgeInsets.all(8.0),
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

  Widget _buildEditListTile(
      String? content, TextEditingController controller, String hint) {
    if (content != null) {
      controller.text = content;
    }
    return Column(
      children: [
        ListTile(
          tileColor: Colors.white,
          title: TextField(
            controller: controller,
            decoration:
                InputDecoration(labelText: hint, border: InputBorder.none),
          ),
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
