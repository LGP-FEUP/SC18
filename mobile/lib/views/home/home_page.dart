import 'package:erasmus_helper/services/user_service.dart';
import 'package:erasmus_helper/views/home/components/person_card.dart';
import 'package:flutter/material.dart';

import '../../models/user.dart';
import '../../services/group_service.dart';
import '../../services/user_interests_service.dart';
import '../social/groups/components/group_card.dart';
import 'components/event_card.dart';

class HomePage extends StatelessWidget {
  final List<String> tagIds = [];

  HomePage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      //padding: const EdgeInsets.all(15.0),
      child: Column(
        children: [_buildGroupList(), _buildPersonList(), _buildEventList()],
      ),
    );
  }

  Widget _buildEventList() {
    return FutureBuilder(
        //TODO: fetch Event Ids from firebase
        future: Future<List<String>>.value(["1", "2", "3"]),
        builder: (context, response) {
          if (response.connectionState == ConnectionState.done) {
            if (response.data != null) {
              List eventIds = response.data as List<String>;

              if (eventIds.isEmpty) return Container();
              return Card(
                  //color: Colors.white,
                  elevation: 0,
                  child: Padding(
                      padding:
                          const EdgeInsets.only(left: 10, top: 10, bottom: 15),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: const [
                              Padding(
                                padding: EdgeInsets.all(5),
                                child: Text(
                                  "Upcoming Events",
                                  style: TextStyle(
                                      fontWeight: FontWeight.w500,
                                      fontSize: 18),
                                ),
                              ),
                            ],
                          ),
                          const SizedBox(
                            height: 5,
                          ),
                          SizedBox(
                              height: 208,
                              child: ListView.builder(
                                  shrinkWrap: true,
                                  scrollDirection: Axis.horizontal,
                                  itemCount: eventIds.length,
                                  itemBuilder:
                                      (BuildContext context, int index) {
                                    return EventCard(eventId: eventIds[index]);
                                  })),
                        ],
                      )));
            }
          }
          return Container();
        });
  }

  Widget _buildGroupList() {
    return FutureBuilder(
        future: _fetchGroups(),
        builder: (context, response) {
          if (response.connectionState == ConnectionState.done) {
            if (response.data != null) {
              List groupIds = response.data as List<String>;

              if (groupIds.isEmpty) return Container();
              return Card(
                  //color: Colors.white,
                  elevation: 0,
                  child: Padding(
                      padding:
                          const EdgeInsets.only(left: 10, top: 10, bottom: 15),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: const [
                              Padding(
                                padding: EdgeInsets.all(5),
                                child: Text(
                                  "Suggested for You",
                                  style: TextStyle(
                                      fontWeight: FontWeight.w500,
                                      fontSize: 18),
                                ),
                              ),
                            ],
                          ),
                          const SizedBox(
                            height: 5,
                          ),
                          SizedBox(
                              height: 208,
                              child: ListView.builder(
                                  shrinkWrap: true,
                                  scrollDirection: Axis.horizontal,
                                  itemCount: groupIds.length,
                                  itemBuilder:
                                      (BuildContext context, int index) {
                                    return GroupCard(groupId: groupIds[index]);
                                  })),
                        ],
                      )));
            }
          }
          return Container();
        });
  }

  Future<List<String>> _fetchGroups() async {
    List<String> groups = [];
    tagIds.clear();
    tagIds.addAll(await UserService.getInterestUIDs());
    for (var tagId in tagIds) {
      groups.addAll(await GroupService.getGroupsWithTag(tagId));
    }
    return groups;
  }

  Widget _buildPersonList() {
    return FutureBuilder(
        future: _getUsersWithSameInterests(),
        builder: (context, response) {
          if (response.connectionState == ConnectionState.done) {
            if (response.data != null) {
              List users = response.data as List<UserModel>;

              if (users.isEmpty) return Container();
              return Card(
                //color: Colors.white,
                elevation: 0,
                child: Padding(
                  padding: const EdgeInsets.only(left: 10, top: 10, bottom: 15),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: const [
                          Padding(
                            padding: EdgeInsets.all(5),
                            child: Text(
                              "Meet new People",
                              style: TextStyle(
                                  fontWeight: FontWeight.w500, fontSize: 18),
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(
                        height: 5,
                      ),
                      SizedBox(
                        height: 208,
                        child: ListView.builder(
                          shrinkWrap: true,
                          scrollDirection: Axis.horizontal,
                          itemCount: users.length,
                          itemBuilder: (BuildContext context, int index) {
                            return PersonCard(users[index]);
                          },
                        ),
                      ),
                    ],
                  ),
                ),
              );
            }
          }
          return Container();
        });
  }

  Future<List<UserModel>> _getUsersWithSameInterests() async {
    UserModel? currentUser = await UserService.getUserProfile();
    if (currentUser != null) {
      List<UserModel> users =
          await UserInterestsService.getUsersWithTags(currentUser.interests) ??
              [];
      return users;
    }
    return [];
  }
}
