import 'package:erasmus_helper/blocs/profile_bloc/profile_bloc.dart';
import 'package:erasmus_helper/blocs/profile_bloc/profile_event.dart';
import 'package:erasmus_helper/blocs/tag_bloc/tag_cubit.dart';
import 'package:erasmus_helper/layout.dart';
import 'package:erasmus_helper/models/user.dart';
import 'package:erasmus_helper/views/app_topbar.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_svg/flutter_svg.dart';

import '../../blocs/profile_bloc/profile_state.dart';
import '../../models/tag.dart';

class ProfileScreen extends StatefulWidget {
  const ProfileScreen({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State {
  late ProfileBloc _profileBloc;
  UserModel? _profile;
  List<Tag> _tags = [];
  final TextEditingController _descriptionController = TextEditingController();
  final TextEditingController _fNameController = TextEditingController();
  final TextEditingController _lNameController = TextEditingController();
  final TextEditingController _phoneController = TextEditingController();
  final TextEditingController _whatsappController = TextEditingController();
  final TextEditingController _facebookController = TextEditingController();

  @override
  void initState() {
    super.initState();
    _profileBloc = ProfileBloc();
    _profileBloc.add(FetchProfileEvent());
  }

  @override
  void dispose() {
    _profileBloc.close();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return MultiBlocProvider(
        providers: [
          BlocProvider<ProfileBloc>(
            create: (_) => _profileBloc,
          ),
          BlocProvider<TagCubit>(create: (_) => TagCubit(<Tag>[])),
        ],
        child: AppLayout(
            title: "Profile",
            activateBackButton: true,
            body: BlocBuilder<ProfileBloc, ProfileState>(
                builder: (blocContext, state) {
              if (state is ProfileFetchedState) {
                _profile = state.profile;
              }
              if (state is ProfileEditingState) {
                _tags = state.tags;
                blocContext.read<TagCubit>().addAll(_profile!.interests);
              }
              if (state is ProfileFetchedState ||
                  state is ProfileEditingState) {
                return Container(
                    padding: const EdgeInsets.all(15.0),
                    child: SingleChildScrollView(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
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
                                        _profile?.facultyOriginName ?? ""),
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
                                    _buildEditListTile(_profile?.description,
                                        _descriptionController, "Description"),
                                    _buildEditListTile(_profile?.phone,
                                        _phoneController, "Phone"),
                                    _buildEditListTile(_profile?.whatsapp,
                                        _whatsappController, "Whatsapp"),
                                    _buildEditListTile(_profile?.facebook,
                                        _facebookController, "Facebook")
                                  ],
                                ),
                          const SizedBox(
                            height: 20.0,
                          ),
                          _buildChipList(
                              blocContext,
                              state is ProfileEditingState,
                              _tags,
                              _profile!.interests),
                          const SizedBox(
                            height: 20.0,
                          ),
                          Center(
                              child: state is ProfileEditingState
                                  ? ElevatedButton(
                                      onPressed: () {
                                        _profile!.fName = _fNameController.text;
                                        _profile!.lName = _lNameController.text;
                                        _profile!.description =
                                            _descriptionController.text;
                                        _profile!.phone = _phoneController.text;
                                        _profile!.whatsapp =
                                            _whatsappController.text;
                                        _profile!.facebook =
                                            _facebookController.text;
                                        _profile!.interests =
                                            blocContext.read<TagCubit>().state;
                                        _profileBloc
                                            .add(SubmitProfileEvent(_profile!));
                                      },
                                      child: const Text("Submit"))
                                  : ElevatedButton(
                                      onPressed: () =>
                                          _profileBloc.add(EditProfileEvent()),
                                      child: const Text("Edit")))
                        ],
                      ),
                    ));
              } else {
                return const Center(
                  child: CircularProgressIndicator(),
                );
              }
            })));
  }

  Widget _buildProfileBanner(bool editing, String fname, String lname,
      String country, String description) {
    return !editing
        ? Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              const CircleAvatar(
                backgroundImage: AssetImage("assets/avatar.png"),
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
                        Expanded(
                            child: Text(
                          "$fname $lname",
                          style: const TextStyle(
                              fontWeight: FontWeight.bold, fontSize: 18),
                        )),
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
        : const Center(
            child: CircleAvatar(
            backgroundImage: AssetImage("assets/avatar.png"),
            radius: 60,
          ));
  }

  SizedBox _getFlag(String countryCode) {
    return SizedBox(
      width: 30,
      height: 25,
      child: SvgPicture.asset(
        "assets/flags/${countryCode == "" ? "eu" : countryCode}.svg",
        fit: BoxFit.fill,
      ),
    );
  }

  Widget _buildChipList(BuildContext context, bool edit, List<Tag> labels,
      List<Tag> userInterests) {
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
          children: !edit
              ? userInterests.map((tag) => _buildChip(tag.title)).toList()
              : _tags.map((tag) => _buildActionChip(context, tag)).toList(),
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

  Widget _buildActionChip(BuildContext context, Tag tag) {
    return BlocBuilder<TagCubit, List<Tag>>(builder: (context, tagList) {
      bool _selected = _containsTag(tag, tagList);
      return ActionChip(
        label: Text(
          tag.title,
          style: _selected
              ? const TextStyle(color: Colors.white)
              : TextStyle(color: Colors.blueGrey.shade600),
        ),
        elevation: 2.0,
        shadowColor: Colors.grey[60],
        backgroundColor: _selected ? Colors.blueGrey.shade600 : Colors.white,
        padding: const EdgeInsets.all(8.0),
        onPressed: () {
          if (_selected) {
            context.read<TagCubit>().remove(tag);
          } else {
            context.read<TagCubit>().add(tag);
          }
        },
      );
    });
  }

  bool _containsTag(Tag compare, List<Tag> tagList) {
    bool contains = false;
    for (var element in tagList) {
      if (element.title == compare.title) {
        contains = true;
      }
    }
    return contains;
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
